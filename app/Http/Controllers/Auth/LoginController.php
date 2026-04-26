<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Admission;
use App\Models\Room;

/**
 * LoginController
 *
 * Handles hospital system authentication with enterprise-grade
     * security: audit logging and secure session regeneration.
     *
     * @package App\Http\Controllers\Auth
     */
final class LoginController extends BaseController
{

    public function create(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->intended(route('dashboard'));
        }

        try {
            $stats = [
                'total_patients'    => Patient::count(),
                'active_doctors'    => Doctor::where('is_active', true)->count(),
                'active_admissions' => Admission::where('status', 'active')->count(),
                'available_beds'    => Room::sum('available') ?? 0,
                'total_beds'        => Room::sum('capacity') ?? 0,
            ];
        } catch (\Exception $e) {
            $stats = [
                'total_patients'    => 0,
                'active_doctors'    => 0,
                'active_admissions' => 0,
                'available_beds'    => 0,
                'total_beds'        => 0,
            ];
        }

        return view('auth.login', compact('stats'));
    }

    /**
     * Handle an incoming authentication request.
     *
     * Validates credentials, regenerates session, and logs the authentication event.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validateLoginRequest($request);

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            $this->logFailedAttempt($request);

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        // Prevent session fixation attacks.
        $request->session()->regenerate();

        $this->logSuccessfulLogin($request);

        return redirect()
            ->intended(route('dashboard'))
            ->with('success', 'Welcome back, ' . Auth::user()->name . '!');
    }

    /**
     * Destroy an authenticated session (logout).
     */
    public function destroy(Request $request): RedirectResponse
    {
        $userName = Auth::user()?->name ?? 'Unknown';

        Log::info('User logged out.', [
            'user'  => $userName,
            'ip'    => $request->ip(),
            'agent' => $request->userAgent(),
        ]);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'You have been securely logged out.');
    }

    // ────────────────────────────────────────────────────────────────
    // Private helpers
    // ────────────────────────────────────────────────────────────────

    /**
     * Validate the incoming login request.
     */
    private function validateLoginRequest(Request $request): void
    {
        $request->validate([
            'email'    => [
                'required',
                'string',
                'email',
                'max:255',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:128',
            ],
        ], [
            'email.required'    => 'An email address is required.',
            'email.email'       => 'Please enter a valid email address.',
            'password.required' => 'A password is required.',
            'password.min'      => 'The password must be at least 8 characters.',
        ]);
    }



    /**
     * Write a structured audit log for failed login attempts.
     */
    private function logFailedAttempt(Request $request): void
    {
        Log::warning('Failed login attempt.', [
            'email'    => $request->input('email'),
            'ip'       => $request->ip(),
            'agent'    => $request->userAgent(),
        ]);
    }

    /**
     * Write a structured audit log on successful authentication.
     */
    private function logSuccessfulLogin(Request $request): void
    {
        Log::info('User authenticated successfully.', [
            'user_id' => Auth::id(),
            'email'   => Auth::user()?->email,
            'ip'      => $request->ip(),
            'agent'   => $request->userAgent(),
        ]);
    }
}
