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
use App\Http\Controllers\SubscriptionController;
use App\Livewire\ClarificationModal;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Main landing page
Route::get('/', LandingPage::class)->name('landing-page');

// Reporting flow routes
Route::get('/choose-report-type', ChooseReportType::class)->name('choose-report-type');
Route::get('/select-abuse-type/{isAnonymous}', AbuseTypeSelection::class)->name('select-abuse-type');
Route::get('/report-form/{abuseTypeID}/{isAnonymous}', ReportForm::class)->name('report-form');
Route::get('/clarify/{caseNumber}', ClarificationModal::class)->name('report.clarify');
Route::get('/check-status', CheckStatus::class)->name('check-status'); // Add this line
Route::get('/edit-report/{caseNumber}', EditReport::class)->name('edit-report');
Route::get('/contact-us', ContactUs::class)->name('contact-us'); 

// Admin Login Flow
// Step 1: The initial username and password form
Route::get('/school-admin', AdminLoginForm::class)->name('school-admin');
//District log in
Route::get('/school-district', DistrictLoginForm::class)->name('school-admin-district');

// Step 2: The email and OTP verification form
Route::get('/email-verification', PasswordlessLogin::class)->name('email.verification')->middleware('auth');

// Step 3: School admin dashboard — protected by auth + subscription check
Route::middleware(['auth', 'subscribed'])->group(function () {
    Route::get('/admin/dashboard', [SchoolAdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/false-reports', [SchoolAdminDashboardController::class, 'falseReports'])->name('admin.false-reports');
    Route::post('/admin/flag-report/{reportId}', [SchoolAdminDashboardController::class, 'flagReport'])->name('admin.flag-report');
    Route::get('/admin/reports', \App\Livewire\AdminReports::class)->name('admin.reports');
    Route::get('/admin/reports/{filter?}', \App\Livewire\AdminReports::class)->name('admin.reports.index');
    Route::get('/admin/settings', \App\Livewire\AdminSettings::class)->name('admin.settings');
});

// District Admin Dashboard
Route::get('/district-admin/dashboard', \App\Livewire\DistrictAdminDashboard::class)->name('district.admin.dashboard')->middleware('auth');

//provincial Admin Report Pages


Route::middleware(['auth'])->group(function () {
    Route::get('/provincial-admin/dashboard', [ProvincialAdminDashboardController::class, 'index'])->name('provincial.admin.dashboard')->middleware('auth');

    Route::get('/provincial/reports', \App\Livewire\ProvincialReport::class)->name('provincial.reports');
    Route::get('/provincial/reports/{filter?}', \App\Livewire\ProvincialReport::class)->name('provincial.reports.index');

     Route::get('/provincial/profile', \App\Livewire\ProvincialSettings::class)->name('provincial.settings');

    Route::get('/provincial/export-pdf/{province}', [ProvincialReportController::class, 'exportPDF'])
    ->name('provincial.export-pdf');

    Route::get('/provincial/dashboard', [ProvincialDashboardController::class, 'index'])
        ->name('provincial.dashboard');

    // AJAX endpoint for chart updates (fetchData)
    Route::get('/provincial/dashboard/fetch', [ProvincialDashboardController::class, 'fetchData'])
        ->name('provincial.dashboard.fetch');
});

// Provincial Admin Settings and Reports
Route::prefix('provincial-admin')->name('provincial-admin.')->middleware('auth')->group(function () {
    Route::get('settings', [ProvincialAdminSettingsController::class, 'index'])->name('settings');
    Route::put('settings', [ProvincialAdminSettingsController::class, 'update'])->name('settings.update');
    Route::get('reports', [ProvincialAdminReportsController::class, 'index'])->name('reports');
    Route::get('reports/{id}', [ProvincialAdminReportsController::class, 'show'])->name('reports.show')->where('id', '[0-9]+');
});



// National Admin Dashboard

Route::get('/national-admin/dashboard', [NationalAdminDashboardController::class, 'index'])
    ->name('national.admin.dashboard')
    ->middleware('auth');
Route::get('/national-admin/reports', [ReportController::class, 'index'])->name('national-admin.reports');
Route::get('/reports/{id}', [ReportController::class, 'show'])->name('reports.show');


Route::prefix('national-admin')->name('national-admin.')->group(function () {
    Route::get('settings', [SettingsController::class, 'index'])->name('settings');
    Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::delete('settings/delete-picture', [SettingsController::class, 'deleteProfilePicture'])
        ->name('settings.delete-picture');
});

// School Admin Reports Page (Controller-based, matching Provincial Admin)
// Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
//     Route::get('reports', [SchoolAdminReportsController::class, 'index'])->name('reports');
//     Route::get('reports/{id}', [SchoolAdminReportsController::class, 'show'])->name('reports.show')->where('id', '[0-9]+');
// });

// Admin Logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
Auth::routes(['verify' => true]);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Routing for filtering data on dashboard
Route::get('/admin/fetch-dashboard-data', [AdminDashboardController::class, 'fetchData'])->name('admin.fetchData');

Route::get('/district/profile', \App\Livewire\DistrictAdminSettings::class)
    ->name('district.profile')
    ->middleware(['auth']);


Route::middleware(['auth', 'role:district'])->group(function () {
    Route::get('/district/settings', DistrictAdminSettings::class)->name('district.settings');
    // New Contact Us Route
});

// ABOUT US PAGE
Route::view('/about-us', 'about.index')->name('about-us');


// Subscription Card Page
Route::get('/admin/subscribe', [SubscriptionController::class, 'index'])
    ->name('admin.subscribe')
    ->middleware('auth');

// Redirection to PayFast
Route::get('/admin/subscribe/checkout/{plan}', [SubscriptionController::class, 'checkout'])
    ->name('admin.checkout')
    ->middleware('auth');

// PayFast Callbacks
Route::get('/payment/success', function() {
    
    $user         = Auth::user();
    $subscription = $user ? \App\Models\Subscription::where('user_id', $user->id)
                                ->where('status', 'pending')
                                ->latest()
                                ->first() : null;

    if ($subscription) {
        $months    = match($subscription->plan) {
            'annual'  => 12,
            'monthly' => 1,
            default   => null,
        };

        $subscription->update([
            'status'     => 'active',
            'starts_at'  => \Carbon\Carbon::now(),
            'expires_at' => $months ? \Carbon\Carbon::now()->addMonths($months) : null,
        ]);

        $user->update(['is_subscribed' => true]);
    }

    return redirect()->route('admin.dashboard')->with('success', 'Subscription activated! Welcome aboard.');
})->name('payment.success')->middleware('auth');

Route::post('/payment/notify', [SubscriptionController::class, 'notify'])->name('payment.notify');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');
    
//Nomination form download
Route::get('/download-nomination', function () {

    $path = public_path('Files/Nomination_Form.pdf');

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->download($path);

})->name('download.nomination');