<?php

namespace Database\Seeders;

use App\Models\Admission;
use Illuminate\Database\Seeder;

class AdmissionSeeder extends Seeder
{
    public function run(): void
    {
        // Rawat Jalan
        Admission::create([
            'patient_id' => 1, // Galih Pratama
            'doctor_id' => 1, // Dr. Ahmad Fauz
            'admission_type' => 'Rawat Jalan',
            'clinic' => 'Poli Umum',
            'admission_date' => now(),
            'status' => 'active',
            'diagnosis' => 'Demam dan batuk',
        ]);

        Admission::create([
            'patient_id' => 2, // Hesti Wulandari
            'doctor_id' => 2, // Dr. Budi Santoso
            'admission_type' => 'Rawat Jalan',
            'clinic' => 'Poli Gigi',
            'admission_date' => now(),
            'status' => 'active',
            'diagnosis' => 'Perawatan gigi rutin',
        ]);

        // Rawat Inap
        Admission::create([
            'patient_id' => 3, // Juwita Sari
            'doctor_id' => 1, // Dr. Ahmad Fauz
            'admission_type' => 'Rawat Inap',
            'clinic' => 'Poli Umum',
            'room_number' => 'Anggrek 101 - Bed Anggrek 101-01',
            'admission_date' => now()->subDays(2),
            'status' => 'active',
            'diagnosis' => 'Infeksi saluran pernapasan',
        ]);

        Admission::create([
            'patient_id' => 4, // Lukman Hakim
            'doctor_id' => 3, // Dr. Siti
            'admission_type' => 'Rawat Inap',
            'clinic' => 'Poli Umum',
            'room_number' => 'Anggrek 102 - Bed Anggrek 102-01',
            'admission_date' => now()->subDay(),
            'status' => 'active',
            'diagnosis' => 'Operasi darurat',
        ]);
    }
}
