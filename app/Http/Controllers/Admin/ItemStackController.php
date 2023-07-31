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

    public function store(ItemStackRequest $request)
    {
        $this->authorize('create', ItemStack::class);

        ItemStack::create($request->validated());
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

        return redirect(route('itemStacks.index'));
    }
}