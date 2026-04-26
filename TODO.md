# TODO — Rawat Inap Section Implementation

- [x] Step 1: Create migration `add_room_id_to_admissions_table.php`
- [x] Step 2: Update `app/Models/Admission.php` (add room_id fillable + room() relationship)
- [x] Step 3: Update `app/Http/Controllers/AdmissionController.php` (validation, unique reg number, room_id)
- [x] Step 4: Update `app/Http/Controllers/DashboardController.php` (inpatient queries with room, summary counts, schedule data)
- [x] Step 5: Update `resources/views/dashboard.blade.php` (sidebar, section, table, modals, JS, calendar)
- [x] Step 6: Run `php artisan migrate`
- [x] Step 7: Test & verify
- [x] Bonus: Jadwal/Kalender section implemented

# TODO — Rekam Medis Section Implementation

- [x] Step 1: Add sidebar item for Rekam Medis
- [x] Step 2: Add `#medicalRecordsSection` with table, filters, summary chips
- [x] Step 3: Add view and edit modals for medical records
- [x] Step 4: Add JavaScript for navigation, CRUD, filtering
- [x] Step 5: Fix form action route
- [x] Step 6: Run migration `create_medical_records_table`
- [x] Step 7: Test & verify

