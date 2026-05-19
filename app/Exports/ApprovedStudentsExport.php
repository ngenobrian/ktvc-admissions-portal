<?php

namespace App\Exports;

use App\Models\Application;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ApprovedStudentsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * Fetch only the approved applications, including their user data
    */
    public function collection()
    {
        return Application::with('user')->where('status', 'approved')->latest()->get();
    }

    /**
    * Map the database columns to the exact Excel rows
    */
    public function map($application): array
    {
        $fullName = strtoupper(trim("{$application->first_name} {$application->middle_name} {$application->surname}"));

        return [
            $application->admission_number,
            $fullName,
            strtoupper($application->gender),
            $application->course_name,
            $application->course_level,
            $application->phone_number,
            $application->user->email ?? $application->user->index_number ?? 'N/A',
            $application->updated_at->format('d-M-Y'), // Date they were approved
        ];
    }

    /**
    * Define the exact column headers at the top of the Excel file
    */
    public function headings(): array
    {
        return [
            'Admission Number',
            'Full Name',
            'Gender',
            'Course Enrolled',
            'Level',
            'Phone Number',
            'Email Address',
            'Date Approved',
        ];
    }
}
