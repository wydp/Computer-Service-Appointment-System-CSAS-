<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ServiceRecordController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;

// ─── Public Routes ───────────────────────────────────────────
Route::get('/', function () {
    return redirect()->route('login');
});

// ─── Logout ──────────────────────────────────────────────────
Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout')->middleware('auth');

// ─── Protected Routes (must be logged in) ────────────────────
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // ── Clients ──────────────────────────────────────────────
    Route::prefix('clients')->name('clients.')->group(function () {
        Route::get('/',              [ClientController::class, 'index'])  ->name('index');
        Route::get('/create',        [ClientController::class, 'create']) ->name('create');
        Route::post('/',             [ClientController::class, 'store'])  ->name('store');
        Route::get('/{client}',      [ClientController::class, 'show'])   ->name('show');
        Route::get('/{client}/edit', [ClientController::class, 'edit'])   ->name('edit');
        Route::put('/{client}',      [ClientController::class, 'update']) ->name('update');
        Route::delete('/{client}',   [ClientController::class, 'destroy'])->name('destroy');
    });

    // ── Appointments ─────────────────────────────────────────
    Route::prefix('appointments')->name('appointments.')->group(function () {
        Route::get('/',                       [AppointmentController::class, 'index'])        ->name('index');
        Route::get('/create',                 [AppointmentController::class, 'create'])       ->name('create');
        Route::post('/',                      [AppointmentController::class, 'store'])        ->name('store');
        Route::get('/{appointment}',          [AppointmentController::class, 'show'])         ->name('show');
        Route::get('/{appointment}/edit',     [AppointmentController::class, 'edit'])         ->name('edit');
        Route::put('/{appointment}',          [AppointmentController::class, 'update'])       ->name('update');
        Route::delete('/{appointment}',       [AppointmentController::class, 'destroy'])      ->name('destroy');
        Route::patch('/{appointment}/status', [AppointmentController::class, 'updateStatus']) ->name('update-status');
    });

    // ── Service Records ───────────────────────────────────────
    Route::prefix('service-records')->name('service-records.')->group(function () {
        Route::get('/',                           [ServiceRecordController::class, 'index'])  ->name('index');
        Route::post('/',                          [ServiceRecordController::class, 'store'])  ->name('store');
        Route::get('/{serviceRecord}/edit',       [ServiceRecordController::class, 'edit'])   ->name('edit');
        Route::patch('/{serviceRecord}',          [ServiceRecordController::class, 'update']) ->name('update');
    });

    // ── Reports ───────────────────────────────────────────────
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
    });

    // ── Users (admin only) ────────────────────────────────────
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/',          [UserController::class, 'index']) ->name('index');
        Route::get('/create',    [UserController::class, 'create'])->name('create');
        Route::post('/',         [UserController::class, 'store']) ->name('store');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });

    // ── API Routes ────────────────────────────────────────────
    Route::prefix('api')->group(function () {
        Route::get('/appointments/{appointment}/tracking', [AppointmentController::class, 'getTracking']);
    });

});

require __DIR__.'/auth.php';