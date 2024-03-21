<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Reservation extends Model implements Rental
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

    public function itemStackNames(): Collection
    {
        return $this->reservationItemStacks()
            ->join('item_stacks', 'item_stack_id', '=', 'item_stacks.id')
            ->pluck('name');
    }

    public function itemStackNamesString(): string
    {
        return implode(', ', $this->itemStackNames()->toArray());
    }

    public function isOpen(): bool
    {
        return !$this->isFulfilled();
    }

    public function getFinishedAtAttribute(): Carbon
    {
        return $this->fulfilled_at;
    }
}
