<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->string('admission_type'); // Rawat Jalan, Rawat Inap
            $table->string('clinic'); // Poli Umum, Poli Gigi, etc
            $table->string('room_number')->nullable(); // For Rawat Inap
            $table->dateTime('admission_date');
            $table->dateTime('discharge_date')->nullable();
            $table->string('status')->default('active'); // active, completed, cancelled
            $table->text('diagnosis')->nullable();
            $table->text('treatment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};
