<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Patient;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function finance()
    {
        $invoices = Invoice::with('patient')->get();
        
        $filename = "laporan_keuangan_" . date('Ymd_His') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];
        
        $columns = ['No. Invoice', 'Tanggal', 'Nama Pasien', 'Total Tagihan', 'Dibayar', 'Status', 'Metode Pembayaran'];
        
        $callback = function() use($invoices, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            
            foreach ($invoices as $invoice) {
                $row = [
                    $invoice->invoice_number,
                    $invoice->created_at->format('Y-m-d H:i:s'),
                    $invoice->patient ? $invoice->patient->name : '-',
                    $invoice->amount,
                    $invoice->paid_amount,
                    $invoice->status,
                    $invoice->payment_method ?? '-'
                ];
                fputcsv($file, $row);
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    public function patients()
    {
        $patients = Patient::all();
        
        $filename = "laporan_pasien_" . date('Ymd_His') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];
        
        $columns = ['No. Rekam Medis', 'Nama Lengkap', 'NIK', 'Tgl Lahir', 'Jenis Kelamin', 'Telepon', 'Alamat'];
        
        $callback = function() use($patients, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            
            foreach ($patients as $patient) {
                $row = [
                    $patient->medical_record_number,
                    $patient->name,
                    $patient->nik,
                    $patient->date_of_birth,
                    $patient->gender == 'M' ? 'Laki-laki' : 'Perempuan',
                    $patient->phone_number,
                    $patient->address
                ];
                fputcsv($file, $row);
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
