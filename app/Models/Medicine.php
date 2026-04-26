<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $fillable = [
        'name',
        'code',
        'stock',
        'minimum_stock',
        'unit',
        'price',
        'description',
        'is_active',
    ];
}
