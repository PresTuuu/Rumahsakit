<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Poliklinik;
use App\Models\Prescription;
use App\Models\Room;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;

final class DashboardController extends BaseController
{
    public function index(): View
    {
        // Statistics
        $totalPatients = Patient::count();
        $activeDoctors = Doctor::where('is_active', true)->count();
        $outpatientToday = Admission::where('admission_type', 'Rawat Jalan')
            ->whereDate('admission_date', today())
            ->whereIn('status', ['menunggu', 'diperiksa'])
            ->count();
        $inpatientTotal = Admission::where('admission_type', 'Rawat Inap')
            ->whereIn('status', ['menunggu', 'dirawat', 'sedang dirawat'])
            ->count();
        $lowStockMedicines = Medicine::whereColumn('stock', '<', 'minimum_stock')->count();
        $pendingInvoices = Invoice::where('status', 'pending')->count();

        // Medicines data
        $medicines = Medicine::orderBy('created_at', 'desc')
            ->take(20)
            ->get();

        $totalMedicines = Medicine::count();
        $activeMedicines = Medicine::where('is_active', true)->count();
        $totalMedicineValue = Medicine::where('is_active', true)
            ->selectRaw('SUM(stock * price) as total_value')
            ->value('total_value') ?? 0;

        // Bed statistics
        $totalBeds = Room::sum('capacity') ?? 0;
        $availableBeds = Room::sum('available') ?? 0;
        $usedBeds = $totalBeds - $availableBeds;

        $todayRevenue = Invoice::whereIn('status', ['lunas', 'sebagian'])
            ->whereDate('paid_date', today())
            ->sum('paid_amount');

        $monthRevenue = Invoice::whereIn('status', ['lunas', 'sebagian'])
            ->whereMonth('paid_date', now()->month)
            ->whereYear('paid_date', now()->year)
            ->sum('paid_amount');

        // Tables Data
        $outpatientAdmissions = Admission::with(['patient', 'doctor'])
            ->where('admission_type', 'Rawat Jalan')
            ->whereIn('status', ['menunggu', 'diperiksa'])
            ->orderBy('admission_date', 'desc')
            ->take(10)
            ->get();

        $inpatientAdmissions = Admission::with(['patient', 'doctor'])
            ->where('admission_type', 'Rawat Inap')
            ->whereIn('status', ['menunggu', 'dirawat', 'sedang dirawat'])
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

        $totalDoctors = Doctor::count();
        $inactiveDoctors = Doctor::where('is_active', false)->count();
        $distinctSpecializations = Doctor::distinct('specialization')->count();
        $polikliniks = Poliklinik::withCount(['doctors', 'admissions'])
            ->orderBy('created_at', 'desc')
            ->get();

        $doctors = Doctor::with('poliklinikRelation')
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();

        // Rawat Jalan data
        $outpatientAll = Admission::with(['patient', 'doctor', 'poliklinik'])
            ->where('admission_type', 'Rawat Jalan')
            ->orderBy('admission_date', 'desc')
            ->take(50)
            ->get();

        $outpatientWaiting = Admission::where('admission_type', 'Rawat Jalan')
            ->where('status', 'menunggu')
            ->count();
        $outpatientExamining = Admission::where('admission_type', 'Rawat Jalan')
            ->where('status', 'diperiksa')
            ->count();
        $outpatientCompleted = Admission::where('admission_type', 'Rawat Jalan')
            ->where('status', 'selesai')
            ->count();
        $outpatientCancelled = Admission::where('admission_type', 'Rawat Jalan')
            ->where('status', 'cancelled')
            ->count();

        // Rawat Inap data
        $inpatientAll = Admission::with(['patient', 'doctor', 'room'])
            ->where('admission_type', 'Rawat Inap')
            ->orderBy('admission_date', 'desc')
            ->take(200)
            ->get();

        $inpatientSedangDirawat = Admission::where('admission_type', 'Rawat Inap')
            ->where('status', 'sedang dirawat')
            ->count();
        $inpatientDirawat = Admission::where('admission_type', 'Rawat Inap')
            ->where('status', 'dirawat')
            ->count();
        $inpatientMenunggu = Admission::where('admission_type', 'Rawat Inap')
            ->where('status', 'menunggu')
            ->count();
        $inpatientSelesai = Admission::where('admission_type', 'Rawat Inap')
            ->where('status', 'selesai')
            ->count();

        // Schedule / Calendar data
        $scheduleAdmissions = Admission::with(['patient', 'doctor'])
            ->orderBy('admission_date', 'desc')
            ->get()
            ->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->admission_date)->format('Y-m-d');
            });

        // Medical Records data
        $medicalRecords = MedicalRecord::with(['patient', 'doctor'])
            ->orderBy('completed_at', 'desc')
            ->take(100)
            ->get();

        $medicalRecordsCount = MedicalRecord::count();
        $medicalRecordsOutpatient = MedicalRecord::where('admission_type', 'Rawat Jalan')->count();
        $medicalRecordsInpatient = MedicalRecord::where('admission_type', 'Rawat Inap')->count();

        // All rooms for dropdowns
        $allRooms = Room::where('status', 'Aktif')->orderBy('room_name')->get();

        // All patients, doctors, polikliniks for dropdowns
        $allPatients = Patient::orderBy('name')->get();
        $allDoctors = Doctor::where('is_active', true)->orderBy('name')->get();
        $allPolikliniks = Poliklinik::where('status', 'Aktif')->orderBy('name')->get();

        // Prescriptions data
        $prescriptions = Prescription::with(['doctor', 'patient', 'items.medicine'])
            ->orderBy('created_at', 'desc')
            ->take(100)
            ->get();

        $totalPrescriptions = Prescription::count();
        $waitingPrescriptions = Prescription::where('status', 'menunggu')->count();
        $givenPrescriptions = Prescription::where('status', 'diberikan')->count();
        $todayPrescriptions = Prescription::whereDate('created_at', today())->count();

        // Invoices data
        $invoices = Invoice::with(['patient', 'admission'])->orderBy('created_at', 'desc')->get();
        $totalInvoicesCount = Invoice::count();
        $paidInvoicesCount = Invoice::where('status', 'lunas')->count();
        $unpaidInvoicesCount = Invoice::where('status', 'belum dibayar')->count();
        $partialInvoicesCount = Invoice::where('status', 'sebagian')->count();

        $admissionsWithoutInvoice = Admission::with('patient')
            ->whereNotIn('id', function($query) {
                $query->select('admission_id')->from('invoices')->whereNotNull('admission_id');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard', [
            'totalPatients' => $totalPatients,
            'activeDoctors' => $activeDoctors,
            'totalDoctors' => $totalDoctors,
            'inactiveDoctors' => $inactiveDoctors,
            'distinctSpecializations' => $distinctSpecializations,
            'polikliniks' => $polikliniks,
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
            'doctors' => $doctors,
            'medicines' => $medicines,
            'totalMedicines' => $totalMedicines,
            'activeMedicines' => $activeMedicines,
            'totalMedicineValue' => $totalMedicineValue,
            'outpatientAll' => $outpatientAll,
            'outpatientAdmissionsToday' => $outpatientAll,
            'outpatientWaiting' => $outpatientWaiting,
            'outpatientExamining' => $outpatientExamining,
            'outpatientCompleted' => $outpatientCompleted,
            'outpatientCancelled' => $outpatientCancelled,
            'inpatientAll' => $inpatientAll,
            'inpatientSedangDirawat' => $inpatientSedangDirawat,
            'inpatientDirawat' => $inpatientDirawat,
            'inpatientMenunggu' => $inpatientMenunggu,
            'inpatientSelesai' => $inpatientSelesai,
            'scheduleAdmissions' => $scheduleAdmissions,
            'medicalRecords' => $medicalRecords,
            'medicalRecordsCount' => $medicalRecordsCount,
            'medicalRecordsOutpatient' => $medicalRecordsOutpatient,
            'medicalRecordsInpatient' => $medicalRecordsInpatient,
            'allRooms' => $allRooms,
            'allPatients' => $allPatients,
            'allDoctors' => $allDoctors,
            'allPolikliniks' => $allPolikliniks,
            'prescriptions' => $prescriptions,
            'totalPrescriptions' => $totalPrescriptions,
            'waitingPrescriptions' => $waitingPrescriptions,
            'givenPrescriptions' => $givenPrescriptions,
            'todayPrescriptions' => $todayPrescriptions,
            'invoices' => $invoices,
            'totalInvoicesCount' => $totalInvoicesCount,
            'paidInvoicesCount' => $paidInvoicesCount,
            'unpaidInvoicesCount' => $unpaidInvoicesCount,
            'partialInvoicesCount' => $partialInvoicesCount,
            'admissionsWithoutInvoice' => $admissionsWithoutInvoice,
        ]);
    }
}
