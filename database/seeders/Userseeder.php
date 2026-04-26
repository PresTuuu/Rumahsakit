<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * UserSeeder
 *
 * Seeds the default administrator account for the MediCore Hospital System.
 *
 * Usage:
 *   php artisan db:seed --class=UserSeeder
 *   php artisan migrate:fresh --seed   (runs all seeders including this one via DatabaseSeeder)
 *
 * Security notes:
 *   - Passwords are hashed using bcrypt with cost factor ≥ 12 (Laravel default).
 *   - The plain-text credentials below are ONLY for local/staging environments.
 *   - In production, rotate the password immediately after first login, and
 *     use environment variables or a secrets manager for sensitive values.
 *
 * @package Database\Seeders
 */
final class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding User Accounts...');

        $this->seedDemoAdmin();
        $this->seedDemoDoctor();
        $this->seedDemoCashier();
        $this->seedDemoPharmacist();

        $this->command->info('User Seeding Completed!');
    }

    // ──────────────────────────────────────────────────────────────
    // Private seeders
    // ──────────────────────────────────────────────────────────────

    /**
     * Create the primary system administrator account.
     */
    private function seedDemoAdmin(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@medicore.hospital'],
            [
                'name'              => 'System Administrator',
                'email'             => 'admin@medicore.hospital',
                'password'          => Hash::make('Admin@MediCore2024!'),
                'email_verified_at' => now(),
                'remember_token'    => Str::random(60),
                'role'              => 'admin',
            ]
        );

        $this->command->info(sprintf('  o" Admin seeded   +  %s', $admin->email));
    }

    /**
     * Create a doctor account.
     */
    private function seedDemoDoctor(): void
    {
        $doctor = User::updateOrCreate(
            ['email' => 'dokter@medicore.hospital'],
            [
                'name'              => 'Dr. Budi Santoso',
                'email'             => 'dokter@medicore.hospital',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
                'remember_token'    => Str::random(60),
                'role'              => 'dokter',
            ]
        );

        $this->command->info(sprintf('  o" Doctor seeded   +  %s', $doctor->email));
    }

    /**
     * Create a cashier account.
     */
    private function seedDemoCashier(): void
    {
        $cashier = User::updateOrCreate(
            ['email' => 'kasir@medicore.hospital'],
            [
                'name'              => 'Mbak Kasir',
                'email'             => 'kasir@medicore.hospital',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
                'remember_token'    => Str::random(60),
                'role'              => 'kasir',
            ]
        );

        $this->command->info(sprintf('  o" Cashier seeded   +  %s', $cashier->email));
    }

    /**
     * Create a pharmacist account.
     */
    private function seedDemoPharmacist(): void
    {
        $pharmacist = User::updateOrCreate(
            ['email' => 'apoteker@medicore.hospital'],
            [
                'name'              => 'Mas Apoteker',
                'email'             => 'apoteker@medicore.hospital',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
                'remember_token'    => Str::random(60),
                'role'              => 'apoteker',
            ]
        );

        $this->command->info(sprintf('  o" Pharmacist seeded   +  %s', $pharmacist->email));
    }
}
