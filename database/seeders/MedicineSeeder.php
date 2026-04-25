<?php

namespace Database\Seeders;

use App\Models\Medicine;
use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    public function run(): void
    {
        $medicines = [
            [
                'name' => 'Paracetamol 500mg',
                'code' => 'OBT-001',
                'stock' => 150,
                'minimum_stock' => 50,
                'unit' => 'Tablet',
                'price' => 15000,
                'description' => 'Pereda demam dan nyeri ringan hingga sedang.',
                'is_active' => true,
            ],
            [
                'name' => 'Amoxicillin 500mg',
                'code' => 'OBT-002',
                'stock' => 80,
                'minimum_stock' => 30,
                'unit' => 'Kapsul',
                'price' => 25000,
                'description' => 'Antibiotik untuk infeksi bakteri.',
                'is_active' => true,
            ],
            [
                'name' => 'Omeprazole 20mg',
                'code' => 'OBT-003',
                'stock' => 45,
                'minimum_stock' => 25,
                'unit' => 'Kapsul',
                'price' => 35000,
                'description' => 'Obat untuk mengurangi produksi asam lambung.',
                'is_active' => true,
            ],
            [
                'name' => 'Cetirizine 10mg',
                'code' => 'OBT-004',
                'stock' => 120,
                'minimum_stock' => 40,
                'unit' => 'Tablet',
                'price' => 12000,
                'description' => 'Antihistamin untuk alergi dan gatal-gatal.',
                'is_active' => true,
            ],
            [
                'name' => 'Metformin 500mg',
                'code' => 'OBT-005',
                'stock' => 8,
                'minimum_stock' => 20,
                'unit' => 'Tablet',
                'price' => 18000,
                'description' => 'Obat diabetes untuk menurunkan gula darah.',
                'is_active' => true,
            ],
            [
                'name' => 'Vitamin C 500mg',
                'code' => 'OBT-006',
                'stock' => 200,
                'minimum_stock' => 50,
                'unit' => 'Tablet',
                'price' => 10000,
                'description' => 'Suplemen vitamin C untuk daya tahan tubuh.',
                'is_active' => true,
            ],
            [
                'name' => 'Ibuprofen 400mg',
                'code' => 'OBT-007',
                'stock' => 60,
                'minimum_stock' => 25,
                'unit' => 'Tablet',
                'price' => 20000,
                'description' => 'Pereda nyeri dan peradangan.',
                'is_active' => true,
            ],
            [
                'name' => 'Salbutamol Inhaler',
                'code' => 'OBT-008',
                'stock' => 0,
                'minimum_stock' => 10,
                'unit' => 'Botol',
                'price' => 85000,
                'description' => 'Bronkodilator untuk asma dan sesak napas.',
                'is_active' => false,
            ],
        ];

        foreach ($medicines as $medicine) {
            Medicine::updateOrCreate(['code' => $medicine['code']], $medicine);
        }
    }
}
