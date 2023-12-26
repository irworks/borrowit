<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Booking extends Model implements Rental
{
    use HasFactory;

    protected $fillable = [
        'notes',
        'organisation_id',
        'user_id',
        'manager_id',
        'from',
        'to',
        'reservation_id',
    ];

    protected $casts = [
        'from' => 'datetime',
        'to' => 'datetime',
        'returned_at' => 'datetime',
    ];

    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(BookingItem::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function manager(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function itemStackNames(): Collection
    {
        return $this->items()
            ->selectRaw("CONCAT(item_stacks.name, ' (', items.name, ')') AS full_name")
            ->join('items', 'booking_items.item_id', '=', 'items.id')
            ->join('item_stacks', 'items.item_stack_id', '=', 'item_stacks.id')
            ->pluck('full_name');
    }

    public function itemStackNamesString(): string
    {
        return implode(', ', $this->itemStackNames()->toArray());
    }

    public function isReturned(): bool
    {
        return $this->returned_at !== null;
    }

    public function isOpen(): bool
    {
        return !$this->isReturned();
    }

    public function getFinishedAtAttribute()
    {
        return $this->returned_at;
    }
}
