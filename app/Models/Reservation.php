<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'notes',
        'organisation_id',
        'user_id',
        'from',
        'to',
        'submitted_at',
        'fulfilled_at',
    ];

    protected $casts = [
        'from' => 'datetime',
        'to' => 'datetime',
        'submitted_at' => 'datetime',
        'fulfilled_at' => 'datetime',
    ];

    public function isFulfilled(): bool
    {
        return $this->fulfilled_at !== null;
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function organisation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Organisation::class);
    }

    public function reservationItemStacks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ReservationItemStack::class);
    }
}
