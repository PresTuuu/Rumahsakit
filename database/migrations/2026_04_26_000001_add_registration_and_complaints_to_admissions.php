<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admissions', function (Blueprint $table) {
            if (!Schema::hasColumn('admissions', 'registration_number')) {
                $table->string('registration_number')->unique()->nullable()->after('id');
            }
            if (!Schema::hasColumn('admissions', 'complaints')) {
                $table->text('complaints')->nullable()->after('clinic');
            }
            if (!Schema::hasColumn('admissions', 'poliklinik_id')) {
                $table->foreignId('poliklinik_id')->nullable()->constrained('polikliniks')->onDelete('set null')->after('doctor_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('admissions', function (Blueprint $table) {
            if (Schema::hasColumn('admissions', 'registration_number')) {
                $table->dropUnique(['registration_number']);
                $table->dropColumn('registration_number');
            }
            if (Schema::hasColumn('admissions', 'complaints')) {
                $table->dropColumn('complaints');
            }
            if (Schema::hasColumn('admissions', 'poliklinik_id')) {
                $table->dropForeign(['poliklinik_id']);
                $table->dropColumn('poliklinik_id');
            }
        });
    }
};
