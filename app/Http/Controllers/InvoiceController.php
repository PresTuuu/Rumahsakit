<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use Illuminate\Routing\Controller as BaseController;

final class InvoiceController extends BaseController
{
    public function update(Request $request, Invoice $invoice): RedirectResponse
    {
        $validated = $request->validate([
            'paid_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $newPaidAmount = $invoice->paid_amount + $validated['paid_amount'];
        
        $status = 'belum dibayar';
        $paidDate = null;

        if ($newPaidAmount >= $invoice->amount) {
            $status = 'lunas';
            $paidDate = now();
        } elseif ($newPaidAmount > 0) {
            $status = 'sebagian';
        }

        $invoice->update([
            'paid_amount' => $newPaidAmount,
            'status' => $status,
            'notes' => $validated['notes'] ?? $invoice->notes,
            'paid_date' => $paidDate,
        ]);

        return redirect()->route('dashboard')->with('activeSection', 'keuangan')->with('status', 'Pembayaran invoice berhasil diperbarui!');
    }

    public function destroy(Invoice $invoice): RedirectResponse
    {
        $invoice->delete();
        return redirect()->route('dashboard')->with('activeSection', 'keuangan')->with('status', 'Invoice berhasil dihapus!');
    }
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'admission_id' => 'required|exists:admissions,id',
            'amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        Invoice::create([
            'patient_id' => $validated['patient_id'],
            'admission_id' => $validated['admission_id'],
            'amount' => $validated['amount'],
            'paid_amount' => 0,
            'status' => 'belum dibayar',
            'due_date' => now()->addDays(7),
            'notes' => $validated['notes'] ?? '',
        ]);

        return redirect()->route('dashboard')->with('activeSection', 'keuangan')->with('status', 'Tagihan baru berhasil dibuat!');
    }

    public function getFinanceDetails(\App\Models\Admission $admission)
    {
        $patientId = $admission->patient_id;
        
        $medicineCost = \Illuminate\Support\Facades\DB::table('prescription_items')
            ->join('prescriptions', 'prescription_items.prescription_id', '=', 'prescriptions.id')
            ->join('medicines', 'prescription_items.medicine_id', '=', 'medicines.id')
            ->where('prescriptions.patient_id', $patientId)
            ->sum(\Illuminate\Support\Facades\DB::raw('prescription_items.quantity * medicines.price'));

        $roomCost = 0;
        $days = 0;
        if ($admission->admission_type === 'Rawat Inap' && $admission->room_id) {
            $room = $admission->room;
            if ($room) {
                $start = \Carbon\Carbon::parse($admission->admission_date);
                $end = $admission->discharge_date ? \Carbon\Carbon::parse($admission->discharge_date) : now();
                $days = max(1, $start->diffInDays($end));
                $roomCost = $days * $room->price_per_day;
            }
        }

        return response()->json([
            'medicine_cost' => (float) $medicineCost,
            'room_cost' => (float) $roomCost,
            'days' => $days,
            'total' => (float) ($medicineCost + $roomCost)
        ]);
    }
}
