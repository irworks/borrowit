<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Models\Item;
use App\Models\Reservation;
use App\Services\ReservationService;

class ItemController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Item::class);

        return Item::all();
    }

    public function store(ItemRequest $request)
    {
        $this->authorize('create', Item::class);

        return Item::create($request->validated());
    }

    public function show(Item $item)
    {
        $this->authorize('view', $item);

        if (request()->expectsJson()) {
            return response()->json([
                'data' => $item
            ]);
        }

        return $item;
    }

    public function showReservationByItemId(Item $item, ReservationService $reservationService)
    {
        $reservation = $reservationService->reservationByItem($item);
        abort_if($reservation === null, 404);

        return redirect(route('reservations.collect', ['reservation' => $reservation]));
    }

    public function update(ItemRequest $request, Item $item)
    {
        $this->authorize('update', $item);

        $item->update($request->validated());

        return $item;
    }

    public function destroy(Item $item)
    {
        $this->authorize('delete', $item);

        $item->delete();

        return response()->json();
    }
}
