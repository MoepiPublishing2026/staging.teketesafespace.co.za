<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =========================
// Public Routes
// =========================
Route::get('/', \App\Livewire\LandingPage::class)->name('landing-page');

Route::get('/choose-report-type', \App\Livewire\ChooseReportType::class)->name('choose-report-type');
Route::get('/select-abuse-type/{isAnonymous}', \App\Livewire\AbuseTypeSelection::class)->name('select-abuse-type');
Route::get('/report-form/{abuseTypeID}/{isAnonymous}', \App\Livewire\ReportForm::class)->name('report-form');
Route::get('/clarify/{caseNumber}', \App\Livewire\ClarificationModal::class)->name('report.clarify');
Route::get('/check-status', \App\Livewire\CheckStatus::class)->name('check-status');
Route::get('/edit-report/{caseNumber}', \App\Livewire\EditReport::class)->name('edit-report');
Route::get('/contact-us', \App\Livewire\ContactUs::class)->name('contact-us');

Route::view('/about-us', 'about.index')->name('about-us');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

// Download nomination form
Route::get('/download-nomination', function () {
    $path = public_path('Files/Nomination_Form.pdf');
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->download($path);
})->name('download.nomination');


// =========================
// Authentication
// =========================
Route::get('/school-admin', \App\Livewire\AdminLoginForm::class)->name('school-admin');
Route::get('/school-district', \App\Livewire\DistrictLoginForm::class)->name('school-admin-district');

Route::get('/email-verification', \App\Livewire\PasswordlessLogin::class)
    ->name('email.verification')
    ->middleware('auth');

Auth::routes(['verify' => true]);

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');


// =========================
// School Admin Routes
// =========================
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', [\App\Http\Controllers\SchoolAdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/false-reports', [\App\Http\Controllers\SchoolAdminDashboardController::class, 'falseReports'])->name('false-reports');
    Route::post('/flag-report/{reportId}', [\App\Http\Controllers\SchoolAdminDashboardController::class, 'flagReport'])->name('flag-report');

    Route::get('/reports/{filter?}', \App\Livewire\AdminReports::class)->name('reports');
    Route::get('/settings', \App\Livewire\AdminSettings::class)->name('settings');

    Route::get('/fetch-dashboard-data', [\App\Http\Controllers\AdminDashboardController::class, 'fetchData'])
        ->name('fetchData');
});


// =========================
// District Admin
// =========================
Route::middleware(['auth'])->prefix('district')->group(function () {

    Route::get('/dashboard', \App\Livewire\DistrictAdminDashboard::class)
        ->name('district.admin.dashboard');

    Route::get('/profile', \App\Livewire\DistrictAdminSettings::class)
        ->name('district.profile');

    Route::get('/settings', \App\Livewire\DistrictAdminSettings::class)
        ->name('district.settings');
});


// =========================
// Provincial Admin
// =========================
Route::prefix('provincial-admin')
    ->name('provincial.admin.')
    ->middleware('auth')
    ->group(function () {

        Route::get('/dashboard', [\App\Http\Controllers\ProvincialAdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/settings', [\App\Http\Controllers\ProvincialAdminSettingsController::class, 'index'])
            ->name('settings');

        Route::put('/settings', [\App\Http\Controllers\ProvincialAdminSettingsController::class, 'update'])
            ->name('settings.update');

        Route::get('/reports', [\App\Http\Controllers\ProvincialAdminReportsController::class, 'index'])
            ->name('reports');

        Route::get('/reports/{id}', [\App\Http\Controllers\ProvincialAdminReportsController::class, 'show'])
            ->name('reports.show')
            ->whereNumber('id');
    });


// =========================
// Provincial General
// =========================
Route::middleware(['auth'])->group(function () {

    Route::get('/provincial/dashboard', [\App\Http\Controllers\ProvincialDashboardController::class, 'index'])
        ->name('provincial.dashboard');

    Route::get('/provincial/dashboard/fetch', [\App\Http\Controllers\ProvincialDashboardController::class, 'fetchData'])
        ->name('provincial.dashboard.fetch');

    Route::get('/provincial/reports/{filter?}', \App\Livewire\ProvincialReport::class)
        ->name('provincial.reports');

    Route::get('/provincial/profile', \App\Livewire\ProvincialSettings::class)
        ->name('provincial.settings');

    Route::get('/provincial/export-pdf/{province}', [\App\Http\Controllers\ProvincialReportController::class, 'exportPDF'])
        ->name('provincial.export-pdf');
});


// =========================
// National Admin
// =========================
Route::prefix('national-admin')
    ->name('national.admin.')
    ->middleware('auth')
    ->group(function () {

        Route::get('/dashboard', [\App\Http\Controllers\NationalAdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])
            ->name('reports');

        Route::get('/reports/{id}', [\App\Http\Controllers\ReportController::class, 'show'])
            ->name('reports.show');

        Route::get('/settings', [\App\Http\Controllers\SettingsController::class, 'index'])
            ->name('settings');

        Route::put('/settings', [\App\Http\Controllers\SettingsController::class, 'update'])
            ->name('settings.update');

        Route::delete('/settings/delete-picture', [\App\Http\Controllers\SettingsController::class, 'deleteProfilePicture'])
            ->name('settings.delete-picture');
    });


// =========================
// SUBSCRIPTION (DISABLED)
// =========================

// Route::get('/admin/subscribe', [SubscriptionController::class, 'index'])
//     ->name('admin.subscribe')
//     ->middleware('auth');

// Route::get('/admin/subscribe/checkout/{plan}', [SubscriptionController::class, 'checkout'])
//     ->name('admin.checkout')
//     ->middleware('auth');

// Route::get('/payment/success', function() {
//     $user         = Auth::user();
//     $subscription = $user ? \App\Models\Subscription::where('user_id', $user->id)
//                                 ->where('status', 'pending')
//                                 ->latest()
//                                 ->first() : null;

//     if ($subscription) {
//         $months    = match($subscription->plan) {
//             'annual'  => 12,
//             'monthly' => 1,
//             default   => null,
//         };

//         $subscription->update([
//             'status'     => 'active',
//             'starts_at'  => \Carbon\Carbon::now(),
//             'expires_at' => $months ? \Carbon\Carbon::now()->addMonths($months) : null,
//         ]);

//         $user->update(['is_subscribed' => true]);
//     }

//     return redirect()->route('admin.dashboard')
//         ->with('success', 'Subscription activated! Welcome aboard.');
// })->name('payment.success')->middleware('auth');

// Route::post('/payment/notify', [SubscriptionController::class, 'notify'])
//     ->name('payment.notify');


// =========================
// Default Home
// =========================
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');