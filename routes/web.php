<?php

declare(strict_types=1);

use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PoliklinikController;
use App\Http\Controllers\PrescriptionController;
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

    Route::post('/doctors', [DoctorController::class, 'store'])
        ->name('doctors.store');

    Route::put('/doctors/{doctor}', [DoctorController::class, 'update'])
        ->name('doctors.update');

    Route::delete('/doctors/{doctor}', [DoctorController::class, 'destroy'])
        ->name('doctors.destroy');

    Route::post('/polikliniks', [PoliklinikController::class, 'store'])
        ->name('polikliniks.store');

    Route::put('/polikliniks/{poliklinik}', [PoliklinikController::class, 'update'])
        ->name('polikliniks.update');

    Route::delete('/polikliniks/{poliklinik}', [PoliklinikController::class, 'destroy'])
        ->name('polikliniks.destroy');

    Route::post('/medicines', [MedicineController::class, 'store'])
        ->name('medicines.store');

    Route::put('/medicines/{medicine}', [MedicineController::class, 'update'])
        ->name('medicines.update');

    Route::delete('/medicines/{medicine}', [MedicineController::class, 'destroy'])
        ->name('medicines.destroy');

    Route::post('/admissions', [AdmissionController::class, 'store'])
        ->name('admissions.store');

    Route::put('/admissions/{admission}', [AdmissionController::class, 'update'])
        ->name('admissions.update');

    Route::delete('/admissions/{admission}', [AdmissionController::class, 'destroy'])
        ->name('admissions.destroy');

    Route::put('/medical-records/{medicalRecord}', [MedicalRecordController::class, 'update'])
        ->name('medical-records.update');

    Route::delete('/medical-records/{medicalRecord}', [MedicalRecordController::class, 'destroy'])
        ->name('medical-records.destroy');

    Route::post('/prescriptions', [PrescriptionController::class, 'store'])
        ->name('prescriptions.store');

    Route::put('/prescriptions/{prescription}', [PrescriptionController::class, 'update'])
        ->name('prescriptions.update');

    Route::delete('/prescriptions/{prescription}', [PrescriptionController::class, 'destroy'])
        ->name('prescriptions.destroy');

    Route::post('/invoices', [InvoiceController::class, 'store'])
        ->name('invoices.store');

    Route::put('/invoices/{invoice}', [InvoiceController::class, 'update'])
        ->name('invoices.update');

    Route::delete('/invoices/{invoice}', [InvoiceController::class, 'destroy'])
        ->name('invoices.destroy');

    Route::get('/api/admissions/{admission}/finance', [InvoiceController::class, 'getFinanceDetails']);
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
