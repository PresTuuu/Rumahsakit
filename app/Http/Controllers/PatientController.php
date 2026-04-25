<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

final class PatientController extends BaseController
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'regex:/^[0-9]{8,15}$/'],
            'address' => ['nullable', 'string', 'max:1000'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:M,F'],
            'blood_type' => ['nullable', 'in:A,B,AB,O'],
            'insurance' => ['nullable', 'in:BPJS,Asuransi Swasta,Tunai/Umum'],
            'room_id' => ['required', 'integer', 'exists:rooms,id'],
        ]);

        $room = Room::where('id', $validated['room_id'])
            ->where('available', '>', 0)
            ->first();

        if (! $room) {
            return back()
                ->withInput()
                ->withErrors(['room_id' => 'Ruangan yang dipilih tidak tersedia.']);
        }

        DB::transaction(function () use ($validated, $room) {
            $room->decrement('available');
            Patient::create([
                'medical_record_number' => $this->generateUniquePatientNumber(),
                'name' => $validated['name'],
                'email' => $validated['email'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'blood_type' => $validated['blood_type'] ?? null,
                'insurance' => $validated['insurance'] ?? null,
                'room_id' => $room->id,
            ]);
        });

        return redirect()->route('dashboard')
            ->with('status', 'Pasien baru berhasil ditambahkan.');
    }

    private function generateUniquePatientNumber(): string
    {
        do {
            $patientNumber = 'PSN-' . random_int(100000, 999999);
        } while (Patient::where('medical_record_number', $patientNumber)->exists());

        return $patientNumber;
    }

    public function update(Request $request, Patient $patient): RedirectResponse
    {
        $validated = $request->validate([
            'medical_record_number' => ['required', 'string', 'max:50', 'regex:/^PSN-[0-9]{6}$/', 'unique:patients,medical_record_number,' . $patient->id],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'regex:/^[0-9]{8,15}$/'],
            'address' => ['nullable', 'string', 'max:1000'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:M,F'],
            'blood_type' => ['nullable', 'in:A,B,AB,O'],
            'insurance' => ['nullable', 'in:BPJS,Asuransi Swasta,Tunai/Umum'],
            'room_id' => ['required', 'integer', 'exists:rooms,id'],
        ]);

        $currentRoom = $patient->room;
        $selectedRoomId = (int) $validated['room_id'];

        if ($currentRoom && $currentRoom->id === $selectedRoomId) {
            $patient->update([
                'medical_record_number' => $validated['medical_record_number'],
                'name' => $validated['name'],
                'email' => $validated['email'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'blood_type' => $validated['blood_type'] ?? null,
                'insurance' => $validated['insurance'] ?? null,
                'room_id' => $currentRoom->id,
            ]);

            return redirect()->route('dashboard')
                ->with('status', 'Data pasien berhasil diperbarui.');
        }

        $room = Room::where('id', $selectedRoomId)
            ->where('available', '>', 0)
            ->first();

        if (! $room) {
            return back()
                ->withInput()
                ->withErrors(['room_id' => 'Ruangan yang dipilih tidak tersedia.']);
        }

        DB::transaction(function () use ($validated, $patient, $currentRoom, $room) {
            if ($currentRoom) {
                $currentRoom->increment('available');
            }

            $room->decrement('available');
            $patient->update([
                'medical_record_number' => $validated['medical_record_number'],
                'name' => $validated['name'],
                'email' => $validated['email'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'blood_type' => $validated['blood_type'] ?? null,
                'insurance' => $validated['insurance'] ?? null,
                'room_id' => $room->id,
            ]);
        });

        return redirect()->route('dashboard')
            ->with('status', 'Data pasien berhasil diperbarui.');
    }

    public function destroy(Patient $patient): RedirectResponse
    {
        if ($patient->room) {
            $patient->room->increment('available');
        }

        $patient->delete();

        return redirect()->route('dashboard')
            ->with('status', 'Pasien berhasil dihapus.');
    }
}
