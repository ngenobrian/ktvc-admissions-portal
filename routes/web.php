<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;

// Homepage
Route::get('/', function () {
    return view('welcome');
});
// Public Pages
Route::get('/programmes', function () {
    return view('programmes');
})->name('programmes');
Route::get('/enquiry', [App\Http\Controllers\EnquiryController::class, 'create'])->name('enquiry.page');
Route::post('/enquiry/submit', [App\Http\Controllers\EnquiryController::class, 'store'])->name('enquiry.submit');

// Authentication Routes (Only for guests)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    // OTP Routes
    Route::get('/verify-otp', [App\Http\Controllers\OtpController::class, 'showVerifyForm'])->name('otp.verify');
    Route::post('/verify-otp', [App\Http\Controllers\OtpController::class, 'verify']);
    Route::post('/resend-otp', [App\Http\Controllers\OtpController::class, 'resend'])->name('otp.resend');

    // Password Reset Routes
Route::get('/forgot-password', [PasswordResetController::class, 'requestForm'])->middleware('guest')->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendEmail'])->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'resetForm'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'updatePassword'])->middleware('guest')->name('password.update');
});

// Protected Routes (Only for logged-in users)
Route::middleware('auth')->group(function () {
    Route::post('/profile/picture', [App\Http\Controllers\ApplicationController::class, 'uploadProfilePicture'])->name('profile.picture.upload');
    // Forced Password Routes
    Route::get('/force-password-change', [App\Http\Controllers\Auth\ForcedPasswordController::class, 'show'])->name('password.force.change');
    Route::post('/force-password-change', [App\Http\Controllers\Auth\ForcedPasswordController::class, 'update'])->name('password.force.update');
    

    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
    
    // Dashboard & Application (Requires OTP Verification)
    Route::get('/dashboard', [App\Http\Controllers\ApplicationController::class, 'dashboard'])->name('dashboard');
    Route::get('/application/apply', [App\Http\Controllers\ApplicationController::class, 'showForm'])->name('application.form');
    Route::get('/application/get-courses', [App\Http\Controllers\ApplicationController::class, 'getEligibleCourses'])->name('application.courses');
    Route::post('/application/autosave', [App\Http\Controllers\ApplicationController::class, 'autosave'])->name('application.autosave');
    Route::post('/application/submit', [App\Http\Controllers\ApplicationController::class, 'store'])->name('application.submit');
    Route::get('/application/admission-letter', [App\Http\Controllers\ApplicationController::class, 'downloadAdmissionLetter'])->name('application.letter.download');

 // Admin Panel Routes (Protected by auth AND our custom AdminAccess middleware)
    Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'force_password_change', \App\Http\Middleware\AdminAccess::class]], function () {
        
        // 1. Dashboard & Analytics
        Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/export-approved', [App\Http\Controllers\AdminController::class, 'exportApprovedStudents'])->name('admin.export.approved');

        // 2. Manage Applications
        Route::get('/applications', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.applications.pending');
        Route::get('/applications/{id}', [App\Http\Controllers\AdminController::class, 'show'])->name('admin.applications.show');
        Route::post('/applications/{id}/status', [App\Http\Controllers\AdminController::class, 'updateStatus'])->name('admin.applications.status');

        // 3. Manage Enquiries
        Route::get('/enquiries', [App\Http\Controllers\EnquiryController::class, 'index'])->name('admin.enquiries.index');
        Route::post('/enquiries/{id}/reply', [App\Http\Controllers\EnquiryController::class, 'reply'])->name('admin.enquiries.reply');

        // 4. Staff Management (Strictly locked to super_admin only via inline middleware)
        Route::group(['middleware' => [function ($request, $next) {
            if (auth()->check() && auth()->user()->role === 'super_admin') {
                return $next($request);
            }
            return redirect()->route('admin.dashboard')->with('error', 'Only Super Admins can access staff management.');
        }]], function () {
            
            // Users Management
            Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('admin.users.index');
            Route::get('/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('admin.users.create');
            Route::post('/users/store', [App\Http\Controllers\UserController::class, 'store'])->name('admin.users.store');
            Route::get('/users/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('admin.users.edit');
            Route::put('/users/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('admin.users.update');
            Route::delete('/users/{id}/archive', [App\Http\Controllers\UserController::class, 'archive'])->name('admin.users.archive');
            Route::post('/users/{id}/restore', [App\Http\Controllers\UserController::class, 'restore'])->name('admin.users.restore');
            
            // Role Management
            Route::get('/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('admin.roles.index');
            Route::post('/roles/store', [App\Http\Controllers\RoleController::class, 'store'])->name('admin.roles.store');
            Route::get('/roles/{id}/edit', [App\Http\Controllers\RoleController::class, 'edit'])->name('admin.roles.edit'); // New!
            Route::put('/roles/{id}', [App\Http\Controllers\RoleController::class, 'update'])->name('admin.roles.update'); // New!
            Route::delete('/roles/{id}', [App\Http\Controllers\RoleController::class, 'destroy'])->name('admin.roles.destroy');
        });
    });
}); 
