<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

final class DoctorController extends BaseController
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'license_number' => ['required', 'string', 'max:50', 'unique:doctors,license_number'],
            'specialization' => ['required', 'string', 'max:100'],
            'poliklinik_id' => ['required', 'integer', 'exists:polikliniks,id'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'regex:/^[0-9]{8,15}$/'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        Doctor::create($validated);

        return redirect()->route('dashboard')
            ->with('status', 'Dokter baru berhasil ditambahkan.');
    }

    public function update(Request $request, Doctor $doctor): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'license_number' => ['required', 'string', 'max:50', 'unique:doctors,license_number,' . $doctor->id],
            'specialization' => ['required', 'string', 'max:100'],
            'poliklinik_id' => ['required', 'integer', 'exists:polikliniks,id'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'regex:/^[0-9]{8,15}$/'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $doctor->update($validated);

        return redirect()->route('dashboard')
            ->with('status', 'Data dokter berhasil diperbarui.');
    }

    public function destroy(Doctor $doctor): RedirectResponse
    {
        $doctor->delete();

        return redirect()->route('dashboard')
            ->with('status', 'Dokter berhasil dihapus.');
    }
}
