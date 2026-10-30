<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\LandingPage;
use App\Livewire\ChooseReportType;
use App\Livewire\AbuseTypeSelection;
use App\Livewire\ReportForm;
use App\Livewire\AdminLoginForm;
use App\Livewire\DistrictLoginForm;
use App\Livewire\PasswordlessLogin;
use App\Livewire\AdminHome;
use App\Livewire\CheckStatus;
use App\Livewire\EditReport;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\NationalAdminDashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use App\Livewire\DistrictAdminSettings;
use App\Http\Controllers\ProvincialReportController;
use App\Http\Controllers\ProvincialDashboardController;
use App\Http\Controllers\ProvincialAdminDashboardController;
use App\Http\Controllers\ProvincialAdminSettingsController;
use App\Http\Controllers\ProvincialAdminReportsController;
use App\Http\Controllers\SchoolAdminDashboardController;
use App\Http\Controllers\SchoolAdminReportsController;
use App\Livewire\ContactUs;
use App\Livewire\ClarificationModal;
use App\Http\Controllers\NationalHeatmapController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Main landing page & Public flows
Route::get('/', LandingPage::class)->name('landing-page');
Route::get('/report-anonymity', ChooseReportType::class)->name('choose-report-type');
Route::get('/types-of-reports/{isAnonymous}', AbuseTypeSelection::class)->name('types-of-reports');
Route::get('/select-abuse-type/{isAnonymous}', function (string $isAnonymous) {
    return redirect()->route('types-of-reports', ['isAnonymous' => $isAnonymous]);
});
Route::get('/report-form/{abuseTypeID}/{isAnonymous}', ReportForm::class)->name('report-form');
Route::get('/clarify/{caseNumber}', ClarificationModal::class)->name('report.clarify');
Route::get('/check-status', CheckStatus::class)->name('check-status');
Route::get('/edit-report/{caseNumber}', EditReport::class)->name('edit-report');
Route::get('/contact-us', ContactUs::class)->name('contact-us');
Route::view('/about-us', 'about.index')->name('about-us');

Route::get('/download-nomination', function () {
    $path = public_path('Files/Nomination_Form.pdf');
    if (!file_exists($path)) { abort(404); }
    return response()->download($path);
})->name('download.nomination');


// Browser CSP violation reports
Route::post('/csp-report', \App\Http\Controllers\CspReportController::class)
    ->middleware('throttle:30,1')
    ->name('csp.report');

// Admin Login Flow
// Step 1: The initial username and password form
// Step 1: The initial username and password form
// ==========================================
// AUTHENTICATION GATEWAY
// ==========================================
Route::get('/secure-portal-auth-9x7/login', AdminLoginForm::class)->name('school-admin');
Route::get('/school-district', DistrictLoginForm::class)->name('school-admin-district');
Route::get('/email-verification', PasswordlessLogin::class)->name('email.verification')->middleware('auth');


// ==========================================
// 1. SCHOOL ADMIN TIER (/admin/...)
// ==========================================
Route::middleware(['auth', 'otp.verified'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [SchoolAdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/false-reports', [SchoolAdminDashboardController::class, 'falseReports'])->name('admin.false-reports');
    Route::post('/flag-report/{reportId}', [SchoolAdminDashboardController::class, 'flagReport'])->name('admin.flag-report');
    Route::get('/reports', \App\Livewire\AdminReports::class)->name('admin.reports');
    Route::get('/reports/{filter?}', \App\Livewire\AdminReports::class)->name('admin.reports.index');
    Route::get('/settings', \App\Livewire\AdminSettings::class)->name('admin.settings');
});


// ==========================================
// 2. DISTRICT ADMIN TIER
// ==========================================
Route::middleware(['auth', 'otp.verified'])->group(function () {
    Route::get('/district-admin/dashboard', \App\Livewire\DistrictAdminDashboard::class)->name('district.admin.dashboard');
    Route::get('/district/profile', \App\Livewire\DistrictAdminSettings::class)->name('district.profile');
});

Route::middleware(['auth', 'otp.verified', 'role:district'])->group(function () {
    Route::get('/district/settings', DistrictAdminSettings::class)->name('district.settings');
});


// ==========================================
// 3. PROVINCIAL ADMIN TIER
// ==========================================
Route::middleware(['auth', 'otp.verified'])->group(function () {
    Route::get('/geojson/{file}', [App\Http\Controllers\GeoJsonController::class, 'show'])
        ->where('file', '[a-z_]+')
        ->name('geojson.show');

    Route::get('/provincial-admin/dashboard', [ProvincialAdminDashboardController::class, 'index'])->name('provincial.admin.dashboard');

    // Heatmap, Profile & Dashboard
    Route::get('/provincial/heatmap', [App\Http\Controllers\ProvincialHeatMapController::class, 'index'])->name('provincial.heatmap');
    Route::get('/provincial/dashboard', [ProvincialDashboardController::class, 'index'])->name('provincial.dashboard');
    Route::get('/provincial/dashboard/fetch', [ProvincialDashboardController::class, 'fetchData'])->name('provincial.dashboard.fetch');
    Route::get('/provincial/export-pdf/{province}', [ProvincialReportController::class, 'exportPDF'])->name('provincial.export-pdf');

    // Livewire Reports & Profile (Using distinct paths so they never collide)
    Route::get('/provincial/profile', \App\Livewire\ProvincialSettings::class)->name('provincial.settings');
    Route::get('/provincial/reports', \App\Livewire\ProvincialReport::class)->name('provincial.reports');
    Route::get('/provincial/reports/{filter?}', \App\Livewire\ProvincialReport::class)->name('provincial.reports.index');
});

Route::prefix('provincial-admin')->name('provincial-admin.')->middleware(['auth', 'otp.verified'])->group(function () {
    Route::get('settings', [ProvincialAdminSettingsController::class, 'index'])->name('settings');
    Route::put('settings', [ProvincialAdminSettingsController::class, 'update'])->name('settings.update');
    Route::get('reports', [ProvincialAdminReportsController::class, 'index'])->name('reports');
    Route::get('reports/{id}', [ProvincialAdminReportsController::class, 'show'])->name('reports.show')->where('id', '[0-9]+');
});

// ==========================================
// 4. NATIONAL ADMIN TIER 
// ==========================================
// ==========================================
// 4. NATIONAL ADMIN TIER 
// ==========================================

// Dashboard, Heatmap & Reports (Dotted naming)
Route::middleware(['auth', 'otp.verified'])
    ->prefix('national-admin')
    ->name('national.admin.')
    ->group(function () {
        Route::get('/dashboard', [NationalAdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/heatmap', [NationalHeatmapController::class, 'index'])->name('heatmap');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports');
        Route::get('/reports/{id}', [ReportController::class, 'show'])->name('reports.show');
    });

// Settings / Profile (Hyphenated naming to match your existing profile views)
Route::middleware(['auth', 'otp.verified'])
    ->prefix('national-admin')
    ->name('national-admin.')
    ->group(function () {
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
        Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
        Route::delete('/settings/delete-picture', [SettingsController::class, 'deleteProfilePicture'])->name('settings.delete-picture');
    });


// ==========================================
// UTILITIES & LOGOUT
// ==========================================
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::get('/attachments/{report}/{file}', [\App\Http\Controllers\AttachmentController::class, 'show'])
    ->middleware(['auth', 'otp.verified'])
    ->whereNumber('report')
    ->where('file', '[^/]+')
    ->name('attachments.show');

Route::get('/report-attachments/{caseNumber}/{file}', [\App\Http\Controllers\AttachmentController::class, 'showForReporter'])
    ->middleware(['signed', 'throttle:60,1'])
    ->where('caseNumber', '[A-Za-z0-9-]+')
    ->where('file', '[^/]+')
    ->name('attachments.reporter');


// ==========================================

// ABOUT US PAGE
Route::view('/about-us', 'about.index')->name('about-us');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/admin/fetch-dashboard-data', [AdminDashboardController::class, 'fetchData'])->name('admin.fetchData');