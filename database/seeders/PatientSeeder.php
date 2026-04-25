<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        Patient::create([
            'name' => 'Galih Pratama',
            'medical_record_number' => 'RM-000008',
            'email' => 'galih@email.com',
            'phone' => '081234567890',
            'address' => 'Jalan Merdeka No. 10',
            'date_of_birth' => '1990-05-15',
            'gender' => 'M',
            'blood_type' => 'O',
        ]);

        Patient::create([
            'name' => 'Hesti Wulandari',
            'medical_record_number' => 'RM-000001',
            'email' => 'hesti@email.com',
            'phone' => '081987654321',
            'address' => 'Jalan Sudirman No. 25',
            'date_of_birth' => '1992-03-22',
            'gender' => 'F',
            'blood_type' => 'A',
        ]);

        Patient::create([
            'name' => 'Juwita Sari',
            'medical_record_number' => 'RM-000009',
            'email' => 'juwita@email.com',
            'phone' => '082345678901',
            'address' => 'Jalan Ahmad Yani No. 50',
            'date_of_birth' => '1988-07-10',
            'gender' => 'F',
            'blood_type' => 'B',
        ]);

        Patient::create([
            'name' => 'Lukman Hakim',
            'medical_record_number' => 'RM-000011',
            'email' => 'lukman@email.com',
            'phone' => '083456789012',
            'address' => 'Jalan Diponegoro No. 75',
            'date_of_birth' => '1985-11-30',
            'gender' => 'M',
            'blood_type' => 'AB',
        ]);
    }
}
