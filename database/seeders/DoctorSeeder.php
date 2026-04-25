<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        Doctor::create([
            'name' => 'Dr. Ahmad Fauz',
            'license_number' => 'LI-001',
            'specialization' => 'Poli Umum',
            'email' => 'ahmad.fauz@hospital.com',
            'phone' => '081111111111',
            'is_active' => true,
        ]);

        Doctor::create([
            'name' => 'Dr. Budi Santoso',
            'license_number' => 'LI-002',
            'specialization' => 'Poli Gigi',
            'email' => 'budi.santoso@hospital.com',
            'phone' => '081222222222',
            'is_active' => true,
        ]);

        Doctor::create([
            'name' => 'Dr. Siti Nurhaliza',
            'license_number' => 'LI-003',
            'specialization' => 'Poli Umum',
            'email' => 'siti.nurhaliza@hospital.com',
            'phone' => '081333333333',
            'is_active' => true,
        ]);

        Doctor::create([
            'name' => 'Dr. Hendrik Wijaya',
            'license_number' => 'LI-004',
            'specialization' => 'Poli Gigi',
            'email' => 'hendrik@hospital.com',
            'phone' => '081444444444',
            'is_active' => true,
        ]);
    }
}
