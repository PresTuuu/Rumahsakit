<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class Room extends Model
{
    protected $fillable = [
        'room_name',
        'room_type',
        'floor',
        'capacity',
        'available',
        'price_per_day',
        'status',
    ];

    protected $casts = [
        'floor' => 'integer',
        'capacity' => 'integer',
        'available' => 'integer',
        'price_per_day' => 'decimal:2',
    ];
}
