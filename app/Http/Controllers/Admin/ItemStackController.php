<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemStackRequest;
use App\Http\Requests\UserRequest;
use App\Models\Category;
use App\Models\ItemStack;
use App\Models\User;
use App\Models\UserRole;
use App\Services\CategoryService;

class ItemStackController extends Controller
{
    public function index(CategoryService $categoryService)
    {
        $this->authorize('viewAny', ItemStack::class);

        return view('item-stacks.index', [
            'itemStacks' => ItemStack::all(), 'categories' => $categoryService->selectArray()
        ]);
    }

    public function show(ItemStack $itemStack)
    {
        $this->authorize('view', $itemStack);

        if (request()->expectsJson()) {
            return response()->json([
                'data' => $itemStack
            ]);
        }
    }

    public function store(ItemStackRequest $request)
    {
        $this->authorize('create', ItemStack::class);
        $data = $request->validated();
        if ($request->has('is_set')) {
            $data['is_set'] = true;
        }

        $itemStack = ItemStack::create($data);
        $itemStack->items()->create([
            'name' => $itemStack->name,
            'is_intact' => true
        ]);

        return redirect(route('itemStacks.index'));
    }

    public function edit(ItemStack $itemStack, CategoryService $categoryService)
    {
        $this->authorize('update', $itemStack);

        return view('item-stacks.edit', [
            'itemStack' => $itemStack, 'categories'  => $categoryService->selectArray()
        ]);
    }

    public function update(ItemStackRequest $request, ItemStack $itemStack)
    {
        $this->authorize('update', $itemStack);
        $data = $request->validated();

        $itemStack->update($data);

        return back();
    }

    public function destroy(ItemStack $itemStack)
    {
        $this->authorize('delete', $itemStack);

        $itemStack->delete();

        return back();
    }
}