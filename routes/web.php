<?php

use App\Http\Controllers\PermitController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

// Dashboard as homepage
Route::get('/', [PermitController::class, 'dashboard'])->name('dashboard');

// Add this after the dashboard route
Route::get('/calendar', [PermitController::class, 'calendar'])->name('permits.calendar');

// bulk operations
Route::post('permits/bulk-reminder', [PermitController::class, 'bulkReminder'])->name('permits.bulk-reminder');
Route::delete('permits/bulk-delete', [PermitController::class, 'bulkDelete'])->name('permits.bulk-delete');

// Permit routes
Route::resource('permits', PermitController::class);
Route::post('permits/{permit}/send-reminder', [PermitController::class, 'sendReminder'])->name('permits.send-reminder');
Route::get('permits/{permit}/history', [PermitController::class, 'history'])->name('permits.history');
Route::delete('permits/{permit}/history/clear', [PermitController::class, 'destroyAllHistory'])->name('permits.history.clear');

// Reminder history routes
Route::get('reminder-history', [PermitController::class, 'allHistory'])->name('permits.all-history');
Route::delete('reminder-history/{history}', [PermitController::class, 'destroyHistory'])->name('reminder-history.destroy');

// Test email route (optional - remove in production)
Route::get('/test-email', function () {
    $permit = \App\Models\Permit::first();

    if ($permit) {
        Mail::to('your-email@gmail.com')->send(new \App\Mail\PermitReminderMail($permit, 'manual'));
        return 'Test email sent!';
    }

    return 'No permit found. Create a permit first.';
});
