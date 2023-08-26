<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'notes',
        'organisation_id',
        'user_id',
        'manager_id',
        'from',
        'to',
        'returned_at',
        'reservation_id',
    ];

    protected $casts = [
        'from' => 'datetime',
        'to' => 'datetime',
        'returned_at' => 'datetime',
    ];
}
