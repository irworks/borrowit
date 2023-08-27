<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Reservation;
use Carbon\Carbon;

class BookingService
{
    public function store(Reservation $reservation, array $itemIds)
    {
        $booking = Booking::create([
            'from' => $reservation->from,
            'to' => $reservation->to,
            'organisation_id' => $reservation->organisation_id,
            'notes' => $reservation->notes,
            'reservation_id' => $reservation->id,
            'user_id' => $reservation->user_id,
            'manager_id' => auth()->user()->id,
        ]);

        foreach ($itemIds as $itemId) {
            $booking->items()->create(['item_id' => $itemId]);
        }

        $reservation->update(['fulfilled_at' => Carbon::now()->toDateTimeString()]);
    }
}