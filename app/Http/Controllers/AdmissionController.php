<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\MedicalRecord;
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

        if ($validated['admission_type'] === 'Rawat Jalan' && !empty($validated['poliklinik_id'])) {
            $lastQueue = Admission::where('admission_type', 'Rawat Jalan')
                ->where('poliklinik_id', $validated['poliklinik_id'])
                ->whereDate('admission_date', \Carbon\Carbon::parse($validated['admission_date'])->toDateString())
                ->max('queue_number');
            $validated['queue_number'] = ($lastQueue ?? 0) + 1;
        }

        $admission = Admission::create($validated);

        // Auto-create medical record if status is selesai
        if ($validated['status'] === 'selesai') {
            $this->createMedicalRecord($admission);
        }

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

        $wasCompleted = $admission->status === 'selesai';
        $isNowCompleted = $validated['status'] === 'selesai';
        $admission->update($validated);

        // Auto-create medical record when status changed to selesai
        if ($isNowCompleted && ! $wasCompleted) {
            $this->createMedicalRecord($admission);
        }

        // Auto-delete medical record when status changed away from selesai
        if (! $isNowCompleted && $wasCompleted) {
            MedicalRecord::where('admission_id', $admission->id)->delete();
        }

        $message = $validated['admission_type'] === 'Rawat Inap'
            ? 'Data rawat inap berhasil diperbarui.'
            : 'Data pendaftaran berhasil diperbarui.';

        return redirect()->route('dashboard')
            ->with('status', $message);
    }

    public function destroy(Admission $admission): RedirectResponse
    {
        // Delete associated medical record if exists
        MedicalRecord::where('admission_id', $admission->id)->delete();

        $admission->delete();

        return redirect()->route('dashboard')
            ->with('status', 'Data pendaftaran berhasil dihapus.');
    }

    private function createMedicalRecord(Admission $admission): void
    {
        $recordNumber = 'RM-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));

        while (MedicalRecord::where('record_number', $recordNumber)->exists()) {
            $recordNumber = 'RM-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
        }

        MedicalRecord::create([
            'admission_id' => $admission->id,
            'record_number' => $recordNumber,
            'patient_id' => $admission->patient_id,
            'doctor_id' => $admission->doctor_id,
            'admission_type' => $admission->admission_type,
            'diagnosis' => $admission->diagnosis,
            'icd_code' => null,
            'icd_description' => null,
            'completed_at' => $admission->updated_at ?? now(),
        ]);
    }
}
