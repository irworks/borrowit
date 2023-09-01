<?php

namespace App\Services;

use App\Models\BookingItem;
use App\Models\Item;
use App\Models\Reservation;
use App\Models\ReservationItemStack;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ReservationService
{
    public function index()
    {
        return Reservation::whereNotNull('submitted_at')
            ->orderBy('fulfilled_at')
            ->orderBy('from');
    }

    public function reservationByItem(Item $item): ?Reservation
    {
        return $this->index()->whereNull('fulfilled_at')
            ->select('reservations.*')
            ->join('reservation_item_stacks', 'reservations.id', '=', 'reservation_item_stacks.reservation_id')
            ->join('items', 'reservation_item_stacks.item_stack_id', '=', 'items.item_stack_id')
            ->where('items.id', '=', $item->id)
            ->where('to', '>=', Carbon::now()->toDateTimeString())
            ->first();
    }

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

    /**
     * Check availability of all ItemStacks once again and mark the
     * reservation as submitted of all good.
     * @param Reservation $reservation
     * @return bool
     */
    public function submit(Reservation $reservation): bool
    {
        $itemsAvailability = $this->checkAvailability($reservation);
        if (!$itemsAvailability['available']) {
            return false;
        }

        return $reservation->update(['submitted_at' => Carbon::now()->toDateTimeString()]);
    }

    /**
     * Checks availability of the included items in their quantity.
     * @param Reservation $reservation
     * @return array
     */
    public function checkAvailability(Reservation $reservation): array
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
            'reservation_item_stack_id' => $reservationItemStack->id,
            'total' => $totalItemsInStack,
            'reserved' => 0,
            'booked' => 0
        ];

        // check other reservations
        $builder = ReservationItemStack::join('reservations', 'reservation_item_stacks.reservation_id', '=', 'reservations.id')
            ->whereNull('fulfilled_at')
            ->whereNotNull('submitted_at')
            ->whereItemStackId($reservationItemStack->item_stack_id);
        $reservedCount = $this->intervalBuilder($builder, $reservation)->count();

        $countUnAvailable += $reservedCount;

        // check other bookings
        $builder = BookingItem::join('bookings', 'booking_items.booking_id', '=', 'bookings.id')
            ->whereNull('returned_at')
            ->whereIn('item_id', $itemStack->items()->select('id'));
        $bookedCount = $this->intervalBuilder($builder, $reservation)->count();

        $countUnAvailable += $bookedCount;

        $result['reserved'] = $reservedCount;
        $result['booked'] = $bookedCount;
        $result['available'] = $reservationItemStack->quantity <= ($totalItemsInStack - $countUnAvailable);
        return $result;
    }

    /**
     * Add a interval where clause which covers
     * all possible interval intersections.
     * @param Builder $builder
     * @param Reservation $reservation
     * @return Builder
     */
    private function intervalBuilder(Builder $builder, Reservation $reservation): Builder
    {
        return $builder->where(function($q) use ($reservation) {
            $q->where(function ($q) use ($reservation) {
                $q->where('from', '<=', $reservation->from)
                    ->where('to', '>=', $reservation->to);
            })->orWhere(function ($q) use ($reservation) {
                $q->where('from', '>=', $reservation->from)
                    ->where('to', '<=', $reservation->to);
            })->orWhere(function ($q) use ($reservation) {
                $q->where('from', '>=', $reservation->from)
                    ->where('from', '<=', $reservation->to)
                    ->where('to', '>=', $reservation->to);
            })->orWhere(function ($q) use ($reservation) {
                $q->where('from', '<=', $reservation->from)
                    ->where('from', '<=', $reservation->to)
                    ->where('to', '>=', $reservation->from);
            });
        });
    }
}
