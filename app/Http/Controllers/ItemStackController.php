<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemStackRequest;
use App\Models\ItemStack;

class ItemStackController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', ItemStack::class);

        return ItemStack::all();
    }

    public function store(ItemStackRequest $request)
    {
        $this->authorize('create', ItemStack::class);

        return ItemStack::create($request->validated());
    }

    public function show(ItemStack $itemStack)
    {
        $this->authorize('view', $itemStack);

        return $itemStack;
    }

    public function update(ItemStackRequest $request, ItemStack $itemStack)
    {
        $this->authorize('update', $itemStack);

        $itemStack->update($request->validated());

        return $itemStack;
    }

    public function destroy(ItemStack $itemStack)
    {
        $this->authorize('delete', $itemStack);

        $itemStack->delete();

        return response()->json();
    }
}
