<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;

class BookingService
{
    public function index()
    {
        return Booking::whereNull('returned_at')
            ->orderBy('to')
            ->orderBy('from');
    }

    public function indexByUser(User $user, bool $onlyOpen)
    {
        $bookings = Booking::whereUserId($user->id)
            ->orderBy('to')
            ->orderBy('from');

        if ($onlyOpen) {
            $bookings = $bookings->whereNull('returned_at');
        }

        return $bookings;
    }

    /**
     * Create a new booking from a reservation and update the reservation.
     * @param Reservation $reservation
     * @param array $itemIds
     * @return bool
     */
    public function store(Reservation $reservation, array $itemIds): bool
    {
        // prevent duplicate bookings from the same reservations
        if (Booking::whereReservationId($reservation->id)->exists()) {
            return false;
        }

        // create the booking
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

        return $reservation->update(['fulfilled_at' => Carbon::now()->toDateTimeString()]);
    }

    /**
     * Return a collection of items
     * @param Booking $booking
     * @param array $returnedItemIds
     * @return bool
     */
    public function returnItems(Booking $booking, array $returnedItemIds): bool
    {
        $bookedItemIds = $booking->items()->select('item_id')->pluck('item_id')->toArray();
        // check if we have returned everything
        if (count( array_diff($bookedItemIds, $returnedItemIds) ) > 0) {
            // TODO: Mark booking as partially returned?
            return false;
        }

        $booking->returned_at = Carbon::now();
        return $booking->save();
    }
}
