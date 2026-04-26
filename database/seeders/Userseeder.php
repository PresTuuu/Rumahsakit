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
        $this->seedSuperAdmin();
        $this->seedDemoStaff();
    }

    // ──────────────────────────────────────────────────────────────
    // Private seeders
    // ──────────────────────────────────────────────────────────────

    /**
     * Create the primary system administrator account.
     *
     * updateOrCreate() is idempotent: re-running the seeder will
     * update existing fields rather than causing a duplicate-key error.
     */
    private function seedSuperAdmin(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@medicore.hospital'],
            [
                'name'              => 'System Administrator',
                'email'             => 'admin@medicore.hospital',
                'password'          => Hash::make('Admin@MediCore2024!'),
                'email_verified_at' => now(),
                'remember_token'    => Str::random(60),

                /*
                 * If you have additional columns (e.g. role, department):
                 *
                 * 'role'       => 'super_admin',
                 * 'department' => 'Administration',
                 * 'is_active'  => true,
                 */
            ]
        );

        $this->command->info(sprintf(
            '  ✓ Super Admin seeded  →  %s  (ID: %d)',
            $admin->email,
            $admin->id
        ));
    }

    /**
     * Create a read-only demo staff account for testing.
     *
     * Remove or comment this method before deploying to production.
     */
    private function seedDemoStaff(): void
    {
        $staff = User::updateOrCreate(
            ['email' => 'staff@medicore.hospital'],
            [
                'name'              => 'Demo Staff',
                'email'             => 'staff@medicore.hospital',
                'password'          => Hash::make('Staff@MediCore2024!'),
                'email_verified_at' => now(),
                'remember_token'    => Str::random(60),

                /*
                 * 'role'       => 'staff',
                 * 'department' => 'General Ward',
                 * 'is_active'  => true,
                 */
            ]
        );

        $this->command->info(sprintf(
            '  ✓ Demo Staff seeded   →  %s  (ID: %d)',
            $staff->email,
            $staff->id
        ));
    }
}
