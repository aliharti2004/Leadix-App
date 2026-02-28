<?php

use App\Http\Controllers\CashflowController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/search', [DashboardController::class, 'search'])->name('search');

    // Leads
    Route::resource('leads', LeadController::class);
    Route::post('leads/{lead}/convert', [LeadController::class, 'convert'])->name('leads.convert');

    // Deals
    Route::get('deals/kanban', [DealController::class, 'kanban'])->name('deals.kanban');
    Route::post('deals/{deal}/update-stage', [DealController::class, 'updateStage'])->name('deals.updateStage');
    Route::post('deals/{deal}/mark-won', [DealController::class, 'markWon'])->name('deals.markWon');
    Route::post('deals/{deal}/mark-lost', [DealController::class, 'markLost'])->name('deals.markLost');
    Route::resource('deals', DealController::class);

    // Invoices - Finance only (checked in controller)
    // IMPORTANT: Specific routes MUST come before parameter routes
    Route::get('/invoices/kanban', [InvoiceController::class, 'kanban'])->name('invoices.kanban');
    Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
    Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/invoices/{invoice}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit');
    Route::get('/invoices/{invoice}/pdf', [InvoiceController::class, 'downloadPdf'])->name('invoices.pdf');
    Route::put('/invoices/{invoice}', [InvoiceController::class, 'update'])->name('invoices.update');
    Route::delete('/invoices/{invoice}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');
    Route::post('/invoices/{invoice}/update-status', [InvoiceController::class, 'updateStatus']);

    // Cashflow (Admin only - checked in controller)
    Route::get('/cashflow', [CashflowController::class, 'index'])->name('cashflow.index');

    // Settings
    Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
        Route::get('/profile', [SettingsController::class, 'profile'])->name('profile');
        Route::put('/profile', [SettingsController::class, 'updateProfile'])->name('profile.update');
        Route::put('/password', [SettingsController::class, 'updatePassword'])->name('password.update');

        // Admin-only settings (checked in controller)
        Route::get('/organization', [SettingsController::class, 'organization'])->name('organization');
        Route::put('/organization', [SettingsController::class, 'updateOrganization'])->name('organization.update');
        Route::get('/team', [TeamController::class, 'index'])->name('team');
        Route::post('/team/invite', [TeamController::class, 'invite'])->name('team.invite');
        Route::delete('/team/{user}', [TeamController::class, 'remove'])->name('team.remove');
    });

    Route::delete('/settings/team/{user}', [TeamController::class, 'destroy'])->name('team.destroy');

    // Contacts
    Route::resource('contacts', ContactController::class);

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // Invitations
    Route::post('/invitations', [InvitationController::class, 'store'])->name('invitations.store');
    Route::delete('/invitations/{invitation}', [InvitationController::class, 'destroy'])->name('invitations.destroy');

    // Notifications
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread-count', [App\Http\Controllers\NotificationController::class, 'getUnreadCount'])->name('notifications.unreadCount');
    Route::get('/notifications/latest', [App\Http\Controllers\NotificationController::class, 'getLatest'])->name('notifications.latest');
    Route::post('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::delete('/notifications/{id}', [App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');


});

// Preview routes for auth pages (accessible while logged in)
Route::get('/preview-login', function () {
    return view('auth.login');
});

Route::get('/preview-register', function () {
    return view('auth.register');
});

// Quick logout route (GET method for convenience)
Route::get('/logout-now', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout.now');

require __DIR__ . '/auth.php'; // Standard Breeze/Jetstream include logic

// Debug route
require __DIR__ . '/debug.php';
