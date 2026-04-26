<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Medicine;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

final class PrescriptionController extends BaseController
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'doctor_id' => ['required', 'exists:doctors,id'],
            'patient_id' => ['required', 'exists:patients,id'],
            'status' => ['required', 'in:menunggu,diberikan'],
            'notes' => ['nullable', 'string'],
            'medicines' => ['required', 'array', 'min:1'],
            'medicines.*.medicine_id' => ['required', 'exists:medicines,id'],
            'medicines.*.quantity' => ['required', 'integer', 'min:1'],
            'medicines.*.instructions' => ['nullable', 'string'],
        ]);

        $prescriptionNumber = $this->generatePrescriptionNumber();

        // Validate stock availability before creating prescription
        foreach ($validated['medicines'] as $item) {
            $medicine = Medicine::find($item['medicine_id']);
            if ($medicine && $medicine->stock < $item['quantity']) {
                return redirect()->route('dashboard')
                    ->with('error', "Stok {$medicine->name} tidak mencukupi. Tersedia: {$medicine->stock}, Dibutuhkan: {$item['quantity']}");
            }
        }

        $prescription = Prescription::create([
            'prescription_number' => $prescriptionNumber,
            'doctor_id' => $validated['doctor_id'],
            'patient_id' => $validated['patient_id'],
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ]);

        foreach ($validated['medicines'] as $item) {
            PrescriptionItem::create([
                'prescription_id' => $prescription->id,
                'medicine_id' => $item['medicine_id'],
                'quantity' => $item['quantity'],
                'instructions' => $item['instructions'] ?? null,
            ]);

            // Deduct medicine stock
            $medicine = Medicine::find($item['medicine_id']);
            if ($medicine) {
                $medicine->stock -= $item['quantity'];
                $medicine->save();
            }
        }

        return redirect()->route('dashboard')
            ->with('status', 'Resep berhasil ditambahkan.');
    }

    public function update(Request $request, Prescription $prescription): RedirectResponse
    {
        $validated = $request->validate([
            'doctor_id' => ['required', 'exists:doctors,id'],
            'patient_id' => ['required', 'exists:patients,id'],
            'status' => ['required', 'in:menunggu,diberikan'],
            'notes' => ['nullable', 'string'],
            'medicines' => ['required', 'array', 'min:1'],
            'medicines.*.medicine_id' => ['required', 'exists:medicines,id'],
            'medicines.*.quantity' => ['required', 'integer', 'min:1'],
            'medicines.*.instructions' => ['nullable', 'string'],
        ]);

        $prescription->update([
            'doctor_id' => $validated['doctor_id'],
            'patient_id' => $validated['patient_id'],
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ]);

        // Restore stock from old items before deleting
        foreach ($prescription->items as $oldItem) {
            $medicine = Medicine::find($oldItem->medicine_id);
            if ($medicine) {
                $medicine->stock += $oldItem->quantity;
                $medicine->save();
            }
        }

        // Validate stock availability for new items
        foreach ($validated['medicines'] as $item) {
            $medicine = Medicine::find($item['medicine_id']);
            if ($medicine && $medicine->stock < $item['quantity']) {
                return redirect()->route('dashboard')
                    ->with('error', "Stok {$medicine->name} tidak mencukupi. Tersedia: {$medicine->stock}, Dibutuhkan: {$item['quantity']}");
            }
        }

        // Delete old items and recreate
        $prescription->items()->delete();

        foreach ($validated['medicines'] as $item) {
            PrescriptionItem::create([
                'prescription_id' => $prescription->id,
                'medicine_id' => $item['medicine_id'],
                'quantity' => $item['quantity'],
                'instructions' => $item['instructions'] ?? null,
            ]);

            // Deduct medicine stock
            $medicine = Medicine::find($item['medicine_id']);
            if ($medicine) {
                $medicine->stock -= $item['quantity'];
                $medicine->save();
            }
        }

        return redirect()->route('dashboard')
            ->with('status', 'Resep berhasil diperbarui.');
    }

    public function destroy(Prescription $prescription): RedirectResponse
    {
        // Restore stock from all items before deleting
        foreach ($prescription->items as $item) {
            $medicine = Medicine::find($item->medicine_id);
            if ($medicine) {
                $medicine->stock += $item->quantity;
                $medicine->save();
            }
        }

        $prescription->items()->delete();
        $prescription->delete();

        return redirect()->route('dashboard')
            ->with('status', 'Resep berhasil dihapus.');
    }

    private function generatePrescriptionNumber(): string
    {
        $date = now()->format('Ymd');
        $count = Prescription::whereDate('created_at', today())->count() + 1;
        $suffix = str_pad((string) $count, 4, '0', STR_PAD_LEFT);

        return "RSP-{$date}-{$suffix}";
    }
}

