<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Room;

class Patient extends Model
{
    protected $fillable = [
        'name',
        'medical_record_number',
        'email',
        'phone',
        'address',
        'date_of_birth',
        'gender',
        'blood_type',
        'insurance',
        'room_id',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
