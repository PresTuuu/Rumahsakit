<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Admission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

final class AdmissionController extends BaseController
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'patient_id' => ['required', 'exists:patients,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'room_id' => ['nullable', 'exists:rooms,id'],
            'poliklinik_id' => ['nullable', 'exists:polikliniks,id'],
            'admission_type' => ['required', 'in:Rawat Jalan,Rawat Inap'],
            'clinic' => ['nullable', 'string', 'max:255'],
            'complaints' => ['nullable', 'string'],
            'room_number' => ['nullable', 'string', 'max:50'],
            'admission_date' => ['required', 'date'],
            'discharge_date' => ['nullable', 'date'],
            'status' => ['required', 'in:active,completed,cancelled,menunggu,diperiksa,selesai,sedang dirawat,dirawat'],
            'diagnosis' => ['nullable', 'string'],
            'treatment' => ['nullable', 'string'],
        ]);

        // Generate unique registration number
        do {
            $validated['registration_number'] = 'ADM-' . strtoupper(\Illuminate\Support\Str::random(8));
        } while (Admission::where('registration_number', $validated['registration_number'])->exists());

        Admission::create($validated);

        $message = $validated['admission_type'] === 'Rawat Inap'
            ? 'Data rawat inap berhasil ditambahkan.'
            : 'Pendaftaran Rawat Jalan berhasil ditambahkan.';

        return redirect()->route('dashboard')
            ->with('status', $message);
    }

    public function update(Request $request, Admission $admission): RedirectResponse
    {
        $validated = $request->validate([
            'patient_id' => ['required', 'exists:patients,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'room_id' => ['nullable', 'exists:rooms,id'],
            'poliklinik_id' => ['nullable', 'exists:polikliniks,id'],
            'admission_type' => ['required', 'in:Rawat Jalan,Rawat Inap'],
            'clinic' => ['nullable', 'string', 'max:255'],
            'complaints' => ['nullable', 'string'],
            'room_number' => ['nullable', 'string', 'max:50'],
            'admission_date' => ['required', 'date'],
            'discharge_date' => ['nullable', 'date'],
            'status' => ['required', 'in:active,completed,cancelled,menunggu,diperiksa,selesai,sedang dirawat,dirawat'],
            'diagnosis' => ['nullable', 'string'],
            'treatment' => ['nullable', 'string'],
        ]);

        $admission->update($validated);

        $message = $validated['admission_type'] === 'Rawat Inap'
            ? 'Data rawat inap berhasil diperbarui.'
            : 'Data pendaftaran berhasil diperbarui.';

        return redirect()->route('dashboard')
            ->with('status', $message);
    }

    public function destroy(Admission $admission): RedirectResponse
    {
        $admission->delete();

        return redirect()->route('dashboard')
            ->with('status', 'Data pendaftaran berhasil dihapus.');
    }
}
