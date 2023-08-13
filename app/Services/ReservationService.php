<?php

namespace App\Services;

use App\Models\ItemStack;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;

class ReservationService
{
    /**
     * Gets the currently active reservation.
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Model|Reservation
     */
    public function currentReservationForUser(User $user): \Illuminate\Database\Eloquent\Model|Reservation
    {
        return $user->reservations()
            ->whereNull('submitted_at')
            ->whereNull('fulfilled_at')
            ->firstOrCreate([], [
                'from' => Carbon::now()->toDateTimeString(),
                'to' => Carbon::now()->toDateTimeString(),
            ]);
    }

    public function addItemStack(Reservation $reservation, ItemStack $itemStack, int $quantity)
    {
        // TODO
        // $reservation->itemStacks()->
    }
}