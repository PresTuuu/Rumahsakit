<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Poliklinik;

class Doctor extends Model
{
    protected $fillable = [
        'name',
        'license_number',
        'specialization',
        'poliklinik',
        'poliklinik_id',
        'email',
        'phone',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = ['poliklinik_name'];

    public function poliklinikRelation(): BelongsTo
    {
        return $this->belongsTo(Poliklinik::class, 'poliklinik_id');
    }

    public function getPoliklinikNameAttribute(): ?string
    {
        return $this->poliklinikRelation?->name ?? $this->attributes['poliklinik'] ?? null;
    }
}
