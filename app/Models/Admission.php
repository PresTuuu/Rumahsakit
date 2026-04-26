<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Admission extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'room_id',
        'poliklinik_id',
        'registration_number',
        'admission_type',
        'clinic',
        'complaints',
        'room_number',
        'admission_date',
        'discharge_date',
        'status',
        'diagnosis',
        'treatment',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function poliklinik(): BelongsTo
    {
        return $this->belongsTo(Poliklinik::class);
    }
}
