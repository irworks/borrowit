<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemRequest;
use App\Models\Item;
use App\Models\ItemStack;
use App\Services\ReservationService;

class ItemController extends Controller
{
    public function store(ItemStack $itemStack, ItemRequest $request)
    {
        $this->authorize('create', Item::class);
        $data = $request->validated();
        $data['is_intact'] = $request->has('is_intact');

        $itemStack->items()->create($data);

        return back();
    }

    public function show(ItemStack $itemStack, Item $item)
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

    public function update(ItemRequest $request, ItemStack $itemStack, Item $item)
    {
        $this->authorize('update', $item);
        $data = $request->validated();
        $data['is_intact'] = $request->has('is_intact');

        $item->update();

        return back();
    }

    public function destroy(ItemStack $itemStack, Item $item)
    {
        $this->authorize('delete', $item);

        $item->delete();

        return back();
    }
}
