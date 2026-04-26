<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

final class MedicalRecordController extends BaseController
{
    public function update(Request $request, MedicalRecord $medicalRecord): RedirectResponse
    {
        $validated = $request->validate([
            'diagnosis' => ['nullable', 'string'],
            'icd_code' => ['nullable', 'string', 'max:20'],
            'icd_description' => ['nullable', 'string', 'max:255'],
        ]);

        $medicalRecord->update($validated);

        return redirect()->route('dashboard')
            ->with('status', 'Data rekam medis berhasil diperbarui.');
    }

    public function destroy(MedicalRecord $medicalRecord): RedirectResponse
    {
        $medicalRecord->delete();

        return redirect()->route('dashboard')
            ->with('status', 'Data rekam medis berhasil dihapus.');
    }
}

