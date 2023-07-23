<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Models\Item;

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

        return $item;
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
