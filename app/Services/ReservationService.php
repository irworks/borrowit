<?php

namespace App\Services;

use App\Models\ItemStack;
use App\Models\Reservation;
use App\Models\ReservationItemStack;
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

    public function addItemStack(Reservation $reservation, int $itemStackId, int $quantity): void
    {
        $reservation->reservationItemStacks()->updateOrCreate(
            ['item_stack_id' => $itemStackId],
            ['quantity' => $quantity]
        );
    }

    public function submit(Reservation $reservation): bool
    {
        $itemsAvailability = $this->checkAvailability($reservation);
        if (!$itemsAvailability['available']) {
            return false;
        }

        $reservation->update(['submitted_at' => Carbon::now()->toDateTimeString()]);
        return true;
    }

    public function checkAvailability(Reservation $reservation)
    {
        $items = [];
        $available = true;

        foreach ($reservation->reservationItemStacks as $reservationItemStack) {
            $item = $this->checkItemAvailability($reservation, $reservationItemStack);
            if (!$item['available']) {
                $available = false;
            }

            $items[] = $item;
        }

        return [
            'available' => $available,
            'items' => $items
        ];
    }

    private function checkItemAvailability(Reservation $reservation, ReservationItemStack $reservationItemStack): array
    {
        $itemStack = $reservationItemStack->itemStack;
        $totalItemsInStack = $itemStack->items()->count();

        $countUnAvailable = 0;
        $result = [
            'available' => true,
            'item' => $itemStack,
            'quantity' => $reservationItemStack->quantity,
            'total' => $totalItemsInStack,
            'reserved' => 0,
            'booked' => 0
        ];

        // check other reservations
        $reservedCount = ReservationItemStack::join('reservations', 'reservation_item_stacks.reservation_id', '=', 'reservations.id')
            ->whereNull('fulfilled_at')
            ->whereNotNull('submitted_at')
            ->whereItemStackId($reservationItemStack->item_stack_id)
            ->where(function($q) use ($reservation) {
                $q->where(function($q) use ($reservation) {
                    $q->where('from', '<=', $reservation->from)
                        ->where('to', '>=', $reservation->to);
                })->orWhere(function ($q) use ($reservation) {
                    $q->where('from', '>=', $reservation->from)
                        ->where('to', '<=', $reservation->to);
                });
            })->count();

        // TODO: Add booked items!
        $countUnAvailable += $reservedCount;

        $result['reserved'] = $reservedCount;
        $result['available'] = $reservationItemStack->quantity <= ($totalItemsInStack - $countUnAvailable);
        return $result;
    }
}