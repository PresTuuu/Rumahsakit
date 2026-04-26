<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Poliklinik extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class);
    }

    public function admissions(): HasManyThrough
    {
        return $this->hasManyThrough(Admission::class, Doctor::class);
    }
}
