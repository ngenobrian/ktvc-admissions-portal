<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Application;


class ApplicationController extends Controller
{
    // 1. Show the Trainee Dashboard
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get the user's application, or create a blank 'draft' one if it doesn't exist
        $application = Application::firstOrCreate(
            ['user_id' => $user->id],
            ['status' => 'draft', 'admission_source' => 'direct']
        );

        return view('dashboard', compact('application'));
    }

    // 2. Show the Application Form
    public function showForm()
    {
        $application = Application::where('user_id', Auth::id())->first();
        
        // Prevent users who have already submitted from accessing the form again
        if ($application && !in_array($application->status, ['draft', 'rejected'])) {
            return redirect()->route('dashboard')->with('error', 'Your application is already submitted.');
        }

        return view('application.form', compact('application'));
    }

    public function store(Request $request)
    {
        // 1. Validate ALL incoming data
        $request->validate([
            // Step 1: Personal
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'surname' => 'required|string|max:255',
            'id_number' => 'required|string|max:50',
            'gender' => 'required|in:Male,Female,Other',
            'dob' => 'required|date',
            'marital_status' => 'required|in:Single,Married',
            'phone_number' => 'required|string|max:20',

            // Step 1.5: Course Selection
            'kcse_grade' => 'required|string',
            'course_level' => 'required|integer',
            'course_name' => 'required|string|max:255',

            // Step 2: Family
            'father_alive' => 'nullable',
            'father_name' => 'required_with:father_alive|nullable|string|max:255',
            'father_phone' => 'required_with:father_alive|nullable|string|max:20',
            'mother_alive' => 'nullable',
            'mother_name' => 'required_with:mother_alive|nullable|string|max:255',
            'mother_phone' => 'required_with:mother_alive|nullable|string|max:20',
            'guardian_name' => 'required|string|max:255',
            'guardian_phone' => 'required|string|max:20',
            'sponsor_name' => 'required|string|max:255',
            'sponsor_phone' => 'required|string|max:20',

            // Step 3: Location
            'po_box' => 'required|string|max:255',
            'town_city' => 'required|string|max:255',
            'home_county' => 'required|string|max:255',
            'sub_county' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'sub_location' => 'required|string|max:255',
            'village' => 'required|string|max:255',
            'chief_name' => 'required|string|max:255',
            'chief_phone' => 'required|string|max:20',

            // Step 4: Documents (Max 2MB per file)
            'kcpe_cert' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'kcse_cert' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'id_card' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'birth_cert' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'consent_given' => 'required',
        ]);

        // 2. Start Database Transaction
        DB::beginTransaction();

        try {
            $user = Auth::user();
            
            // Update the user's profile with their official name
            $user->name = $request->first_name . ' ' . $request->surname;
            $user->save();

            // Find their draft application
            $application = Application::where('user_id', $user->id)->firstOrFail();

            // Update main application details & change status to submitted
            $application->update([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'surname' => $request->surname,
                'id_number' => $request->id_number,
                'gender' => $request->gender,
                'dob' => $request->dob,
                'marital_status' => $request->marital_status,
                'phone_number' => $request->phone_number,
                
                // <-- The 3 new fields added here -->
                'kcse_grade' => $request->kcse_grade,
                'course_level' => $request->course_level,
                'course_name' => $request->course_name,
                
                'consent_given' => $request->has('consent_given'),
                'status' => 'pending',
            ]);

            // Save Address
            $application->address()->updateOrCreate([
                'po_box' => $request->po_box,
                'town_city' => $request->town_city,
                'home_county' => $request->county,
                'sub_county' => $request->sub_county,
                'location' => $request->location,
                'sub_location' => $request->sub_location,
                'village' => $request->village,
                'chief_name' => $request->chief_name,
                'chief_phone' => $request->chief_phone,
            ]);

            // Save Emergency Contacts (Father)
            $application->emergencyContacts()->updateOrCreate([
                'contact_type' => 'father',
                'is_alive' => $request->has('father_alive'),
                'full_name' => $request->has('father_alive') ? $request->father_name : null,
                'phone_number' => $request->has('father_alive') ? $request->father_phone : null,
            ]);

            // Save Emergency Contacts (Mother)
            $application->emergencyContacts()->updateOrCreate([
                'contact_type' => 'mother',
                'is_alive' => $request->has('mother_alive'),
                'full_name' => $request->has('mother_alive') ? $request->mother_name : null,
                'phone_number' => $request->has('mother_alive') ? $request->mother_phone : null,
            ]);

            // Save Guardian & Sponsor
            $application->emergencyContacts()->updateOrCreate([
                'contact_type' => 'guardian',
                'is_alive' => true,
                'full_name' => $request->guardian_name,
                'phone_number' => $request->guardian_phone,
            ]);
            $application->emergencyContacts()->updateOrCreate([
                'contact_type' => 'fee_sponsor',
                'is_alive' => true,
                'full_name' => $request->sponsor_name,
                'phone_number' => $request->sponsor_phone,
            ]);

            // Process and Store File Uploads
            $docTypes = [
                'kcpe_cert' => 'kcpe',
                'kcse_cert' => 'kcse',
                'id_card' => 'national_id',
                'birth_cert' => 'birth_cert'
            ];

            foreach ($docTypes as $inputName => $dbType) {
                if ($request->hasFile($inputName)) {
                    // This stores the file in storage/app/public/admissions
                    $path = $request->file($inputName)->store('admissions', 'public');
                    
                    $application->documents()->create([
                        'document_type' => $dbType,
                        'file_path' => $path,
                    ]);
                }
            }

            // If everything above worked perfectly, commit the changes to the database!
            DB::commit();

            return redirect()->route('dashboard')->with('success', 'Your application has been submitted successfully to the Registrar!');

        } catch (\Exception $e) {
            // If anything fails (like a file upload error), undo all database inserts
            DB::rollBack();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
        }
    }

    // Add this method to ApplicationController
    public function autosave(Request $request)
    {
        $user = Auth::user();
        $application = Application::firstOrCreate(
            ['user_id' => $user->id],
            ['status' => 'draft']
        );

        // 1. Save Main Details
        $application->update($request->only([
            'first_name', 'middle_name', 'surname', 'id_number', 
           'gender', 'dob', 'marital_status', 'phone_number',
            'kcse_grade', 'course_level', 'course_name' // <-- The 3 new fields added here
        ]));

        // 2. Save Address Details (if any exist in the request)
        if ($request->hasAny(['po_box', 'town_city', 'county'])) {
            $application->address()->updateOrCreate(
                ['application_id' => $application->id],
                $request->only(['po_box', 'town_city', 'county', 'sub_county', 'location', 'sub_location', 'village', 'chief_name', 'chief_phone'])
            );
        }

        // 3. Save Emergency Contacts
        $contactTypes = [
            'father' => ['full_name' => 'father_name', 'phone_number' => 'father_phone', 'is_alive' => 'father_alive'],
            'mother' => ['full_name' => 'mother_name', 'phone_number' => 'mother_phone', 'is_alive' => 'mother_alive'],
            'guardian' => ['full_name' => 'guardian_name', 'phone_number' => 'guardian_phone', 'is_alive' => null],
            'fee_sponsor' => ['full_name' => 'sponsor_name', 'phone_number' => 'sponsor_phone', 'is_alive' => null],
        ];

        foreach ($contactTypes as $type => $fields) {
            if ($request->filled($fields['full_name']) || $request->filled($fields['phone_number'])) {
                $application->emergencyContacts()->updateOrCreate(
                    ['application_id' => $application->id, 'contact_type' => $type],
                    [
                        'full_name' => $request->input($fields['full_name']),
                        'phone_number' => $request->input($fields['phone_number']),
                        'is_alive' => $fields['is_alive'] ? $request->has($fields['is_alive']) : true,
                    ]
                );
            }
        }

        return response()->json(['success' => true, 'message' => 'Draft saved automatically.']);
    }

    // Fetch courses based on KCSE grade via AJAX
    public function getEligibleCourses(Request $request)
    {
        $grade = $request->grade;
        $level = 0;

        // Determine Level based on KNQA/TVETA guidelines
        if ($grade === 'KCPE') {
            $level = 3;
        } elseif (in_array($grade, ['E', 'D-'])) {
            $level = 4;
        } elseif (in_array($grade, ['D', 'D+'])) {
            $level = 5;
        } elseif (in_array($grade, ['C-', 'C', 'C+', 'B-', 'B', 'B+', 'A-', 'A'])) {
            $level = 6;
        }

        // KTVC Course List grouped by Level (From your brochure)
        $allCourses = [
            6 => [
                'Civil Engineering', 'Building Construction Technology', 'Land Surveying', 'Quantity Surveying', 
                'Water Engineering', 'Architectural Technology', 'Mechanical Plant Engineering Tech', 
                'Mechanical Technology (Production)', 'Automotive Engineering', 'Agriculture Extension', 
                'Science Laboratory Technology', 'Information Communication Technology (ICT)', 
                'Food and Beverage', 'Fashion Design', 'Cosmetology (Hairdressing & Beauty Therapy)', 
                'Electrical Engineering (Power Option)', 'Social Work & Community Development', 'Office Administration'
            ],
            5 => [
                'Building Technology', 'Land Surveying', 'Plumbing', 'Mechanical Production Technology', 
                'Automotive Engineering', 'Welding and Fabrication', 'Agriculture Extension', 
                'Science Laboratory Technology', 'Information Communication Technology (ICT)', 
                'Food and Beverage', 'Fashion Design', 'Cosmetology (Hairdressing & Beauty Therapy)', 
                'Electrical Operation (Power)', 'Solar PV System Installation', 'Social Work & Community Development', 'Office Administration'
            ],
            4 => [
                'Plumbing', 'Masonry', 'CNC Lathe Operation', 'General Agriculture', 'Automotive Technology', 
                'Welding', 'Information Communication Technology (ICT)', 'Food and Beverage', 'Fashion Design', 
                'Cosmetology (Hairdressing & Beauty Therapy)', 'Electrical Installation', 'Solar PV System Installation', 'Office Assistance'
            ],
            3 => [
                'Plumbing', 'Masonry', 'Automotive Mechanics', 'Welding', 'Food and Beverage', 'Fashion Design', 
                'Cosmetology (Hairdressing & Beauty Therapy)', 'Electrical Installation', 'Solar PV System Installation'
            ]
        ];

        // Return the determined level and the matching courses
        if ($level == 0) {
            return response()->json(['success' => false, 'message' => 'Invalid Grade']);
        }

        return response()->json([
            'success' => true, 
            'level' => $level, 
            'courses' => $allCourses[$level] ?? []
        ]);
    }

    // Download the DOCX Admission Letter
    public function downloadAdmissionLetter()
    {
        // Eager load all relationships to ensure we have access to addresses and contacts
        $application = Application::with(['user', 'address', 'emergencyContacts'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Security check
        if ($application->status !== 'approved') {
            return redirect()->route('dashboard')->with('error', 'Your application is not approved yet.');
        }

        $templatePath = storage_path('app/templates/admission_letter_template.docx');

        if (!file_exists($templatePath)) {
            return redirect()->route('dashboard')->with('error', 'The admission letter template is missing from the server.');
        }

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);

        // ==========================================
        // DATA PREPARATION & CONDITIONAL LOGIC
        // ==========================================

        $address = $application->address;
        $emailOrId = $application->user->email ?? $application->user->index_number;
        
        // Name breakdown (handling potential null middle names)
        $firstName = strtoupper($application->first_name);
        $middleName = strtoupper($application->middle_name ?? '');
        $surname = strtoupper($application->surname);
        // We will also keep a combined FULL_NAME just in case you need it somewhere in the document
        $fullName = trim("{$firstName} {$middleName} {$surname}");

        // Parent Logic: Check if alive. If not, set to DECEASED and N/A
        $father = $application->emergencyContacts->where('contact_type', 'father')->first();
        $fatherName = ($father && $father->is_alive) ? strtoupper($father->full_name) : 'DECEASED';
        $fatherPhone = ($father && $father->is_alive && $father->phone_number) ? $father->phone_number : 'N/A';

        $mother = $application->emergencyContacts->where('contact_type', 'mother')->first();
        $motherName = ($mother && $mother->is_alive) ? strtoupper($mother->full_name) : 'DECEASED';
        $motherPhone = ($mother && $mother->is_alive && $mother->phone_number) ? $mother->phone_number : 'N/A';

        // Guardian & Sponsor Logic
        $guardian = $application->emergencyContacts->where('contact_type', 'guardian')->first();
        $sponsor = $application->emergencyContacts->where('contact_type', 'fee_sponsor')->first();

        // ==========================================
        // MAP DATA TO WORD PLACEHOLDERS
        // ==========================================

        // Standard System Tags
        $templateProcessor->setValue('ADMISSION_NUMBER', $application->admission_number);
        $templateProcessor->setValue('CURRENT_DATE', date('d F Y'));

        // Personal & Course Data (Now broken down!)
        $templateProcessor->setValue('FIRST_NAME', $firstName);
        $templateProcessor->setValue('MIDDLE_NAME', $middleName);
        $templateProcessor->setValue('SURNAME', $surname);
        $templateProcessor->setValue('FULL_NAME', $fullName); // Included just in case
        
        $templateProcessor->setValue('COURSE_NAME', strtoupper($application->course_name));
        $templateProcessor->setValue('LEVEL', $application->course_level);
        $templateProcessor->setValue('GENDER', strtoupper($application->gender));
        $templateProcessor->setValue('DOB', date('d M Y', strtotime($application->dob)));
        $templateProcessor->setValue('MARITAL_STATUS', strtoupper($application->marital_status));
        $templateProcessor->setValue('PHONE_NUMBER', $application->phone_number);
        $templateProcessor->setValue('EMAIL_ADDRESS', $emailOrId);

        // Family & Sponsors
        $templateProcessor->setValue('FATHER_NAME', $fatherName);
        $templateProcessor->setValue('FATHER_PHONE', $fatherPhone);
        $templateProcessor->setValue('MOTHER_NAME', $motherName);
        $templateProcessor->setValue('MOTHER_PHONE', $motherPhone);
        $templateProcessor->setValue('GUARDIAN_NAME', strtoupper($guardian->full_name ?? 'N/A'));
        $templateProcessor->setValue('GUARDIAN_PHONE', $guardian->phone_number ?? 'N/A');
        $templateProcessor->setValue('SPONSOR_NAME', strtoupper($sponsor->full_name ?? 'N/A'));
        $templateProcessor->setValue('SPONSOR_PHONE', $sponsor->phone_number ?? 'N/A');

        // Location & Address
        $templateProcessor->setValue('PO_BOX', strtoupper($address->po_box ?? 'N/A'));
        $templateProcessor->setValue('TOWN_CITY', strtoupper($address->town_city ?? 'N/A'));
        $templateProcessor->setValue('HOME_COUNTY', strtoupper($address->home_county ?? 'N/A'));
        $templateProcessor->setValue('SUB_COUNTY', strtoupper($address->sub_county ?? 'N/A'));
        $templateProcessor->setValue('LOCATION', strtoupper($address->location ?? 'N/A'));
        $templateProcessor->setValue('SUB_LOCATION', strtoupper($address->sub_location ?? 'N/A'));
        $templateProcessor->setValue('VILLAGE', strtoupper($address->village ?? 'N/A'));
        $templateProcessor->setValue('CHIEF_NAME', strtoupper($address->chief_name ?? 'N/A'));
        $templateProcessor->setValue('CHIEF_PHONE', $address->chief_phone ?? 'N/A');

        // ==========================================
        // SAVE AS DOCX & CONVERT TO PDF VIA ILOVEPDF
        // ==========================================

        // 1. Save the filled Word document temporarily
        $docxFileName = 'temp_' . str_replace('/', '_', $application->admission_number) . '.docx';
        $tempDocxPath = storage_path('app/' . $docxFileName);
        $templateProcessor->saveAs($tempDocxPath);

        // 2. Determine the exact path where iLovePDF will save the file
        // iLovePDF automatically keeps the original filename but changes the extension to .pdf
        $pdfFileName = str_replace('.docx', '.pdf', $docxFileName);
        $tempPdfPath = storage_path('app/' . $pdfFileName);

        try {
            // 3. Initialize iLovePDF with credentials from your .env file
            $ilovepdf = new \Ilovepdf\Ilovepdf(env('ILOVEPDF_PUBLIC_KEY'), env('ILOVEPDF_SECRET_KEY'));

            // 4. Create a new "Office to PDF" conversion task
            $myTask = $ilovepdf->newTask('officepdf');

            // 5. Add our temporary DOCX file to the task
            $myTask->addFile($tempDocxPath);

            // 6. Execute the conversion on iLovePDF's servers
            $myTask->execute();

            // 7. Download the resulting PDF back to our server's storage/app directory
            $myTask->download(storage_path('app/'));

        } catch (\Exception $e) {
            // If the API fails, delete the temp DOCX and show an error
            if (file_exists($tempDocxPath)) unlink($tempDocxPath);
            return redirect()->route('dashboard')->with('error', 'Document conversion failed: ' . $e->getMessage());
        }

        // 8. Clean up the temporary DOCX file from your server
        if (file_exists($tempDocxPath)) {
            unlink($tempDocxPath);
        }

        // 9. Download the perfect PDF to the student and delete it from the server immediately after
        return response()->download($tempPdfPath, 'KTVC_Admission_Letter.pdf')->deleteFileAfterSend(true);
    }

    // Handle Profile Picture Upload
    public function uploadProfilePicture(Request $request)
    {
        $request->validate([
            // Enforce strictly images, max size 2MB (2048 KB)
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = auth()->user();

        // 1. If the user already has a picture, delete the old one from the server to save space
        if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        // 2. Save the new image to the 'profile_pictures' folder
        $imagePath = $request->file('profile_picture')->store('profile_pictures', 'public');

        // 3. Update the database
        $user->update([
            'profile_picture' => $imagePath
        ]);

        return redirect()->route('dashboard')->with('success', 'Profile picture updated successfully!');
    }
}
