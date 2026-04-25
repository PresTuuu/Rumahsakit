<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — MediCore Hospital System
|--------------------------------------------------------------------------
|
| Route definitions follow the "thin routes, fat controllers" principle.
| All authentication state is managed via Laravel's built-in Auth guard.
| CSRF protection is automatically applied to every non-GET route.
|
*/

// ── Public root redirect ──────────────────────────────────────────────────
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');


// ── Guest-only routes (unauthenticated users) ─────────────────────────────
Route::middleware(['guest'])->group(function (): void {

    /**
     * GET  /login  →  Show the login form.
     * POST /login  →  Process credentials and establish session.
     */
    Route::get('/login', [LoginController::class, 'create'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'store'])
        ->name('login.store');
});


// ── Authenticated routes (requires valid session) ─────────────────────────
Route::middleware(['auth'])->group(function (): void {

    /**
     * POST /logout  →  Invalidate session and redirect to login.
     *
     * Using POST + CSRF token prevents CSRF-based logout attacks.
     */
    Route::post('/logout', [LoginController::class, 'destroy'])
        ->name('logout');

    /**
     * GET /dashboard  →  Hospital system main dashboard.
     *
     * This is the landing page after a successful login.
     * Swap DashboardController for your actual controller.
     */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::post('/patients', [PatientController::class, 'store'])
        ->name('patients.store');

    Route::put('/patients/{patient}', [PatientController::class, 'update'])
        ->name('patients.update');

    Route::delete('/patients/{patient}', [PatientController::class, 'destroy'])
        ->name('patients.destroy');

    Route::post('/rooms', [RoomController::class, 'store'])
        ->name('rooms.store');

    Route::put('/rooms/{room}', [RoomController::class, 'update'])
        ->name('rooms.update');

    Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])
        ->name('rooms.destroy');

    /*
    |------------------------------------------------------------------
    | Extend your authenticated routes here, for example:
    |------------------------------------------------------------------
    |
    | Route::resource('patients',  PatientController::class);
    | Route::resource('doctors',   DoctorController::class);
    | Route::resource('schedules', ScheduleController::class);
    |
    */
});


// ── Named throttle configuration (add to RouteServiceProvider) ───────────
//
//  RateLimiter::for('login', function (Request $request) {
//      return Limit::perMinute(10)->by(
//          optional($request->user())->id ?: $request->ip()
//      );
//  });
//
// Already handled in LoginController via RateLimiter facade for
// fine-grained, per-email+IP control.
