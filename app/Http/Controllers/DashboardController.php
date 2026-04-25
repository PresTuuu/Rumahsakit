<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Room;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;

final class DashboardController extends BaseController
{
    /**
     * Show the main dashboard page.
     */
    public function index(): View
    {
        // Statistics
        $totalPatients = Patient::count();
        $activeDoctors = Doctor::where('is_active', true)->count();
        $outpatientToday = Admission::where('admission_type', 'Rawat Jalan')
            ->whereDate('admission_date', today())
            ->where('status', 'active')
            ->count();
        $inpatientTotal = Admission::where('admission_type', 'Rawat Inap')
            ->where('status', 'active')
            ->count();
        $lowStockMedicines = Medicine::where('stock', '<', 10)->count();
        $pendingInvoices = Invoice::where('status', 'pending')->count();

        // Bed statistics
        $totalBeds = Room::sum('capacity') ?? 0;
        $availableBeds = Room::sum('available') ?? 0;
        $usedBeds = $totalBeds - $availableBeds;

        $todayRevenue = Invoice::where('status', 'paid')
            ->whereDate('paid_date', today())
            ->sum('amount');

        $monthRevenue = Invoice::where('status', 'paid')
            ->whereMonth('paid_date', now()->month)
            ->whereYear('paid_date', now()->year)
            ->sum('amount');

        // Tables Data
        $outpatientAdmissions = Admission::with(['patient', 'doctor'])
            ->where('admission_type', 'Rawat Jalan')
            ->where('status', 'active')
            ->orderBy('admission_date', 'desc')
            ->take(10)
            ->get();

        $inpatientAdmissions = Admission::with(['patient', 'doctor'])
            ->where('admission_type', 'Rawat Inap')
            ->where('status', 'active')
            ->orderBy('admission_date', 'desc')
            ->take(10)
            ->get();

        $patients = Patient::with('room')
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();

        $totalRooms = Room::count();
        $rooms = Room::orderBy('created_at', 'desc')
            ->take(20)
            ->get();

        return view('dashboard', [
            'totalPatients' => $totalPatients,
            'activeDoctors' => $activeDoctors,
            'outpatientToday' => $outpatientToday,
            'inpatientTotal' => $inpatientTotal,
            'lowStockMedicines' => $lowStockMedicines,
            'pendingInvoices' => $pendingInvoices,
            'todayRevenue' => $todayRevenue,
            'monthRevenue' => $monthRevenue,
            'totalBeds' => $totalBeds,
            'availableBeds' => $availableBeds,
            'usedBeds' => $usedBeds,
            'outpatientAdmissions' => $outpatientAdmissions,
            'inpatientAdmissions' => $inpatientAdmissions,
            'patients' => $patients,
            'totalRooms' => $totalRooms,
            'rooms' => $rooms,
        ]);
    }
}
