<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ItemStack;

class ItemStackController extends Controller
{
    public function show(Category $category, ItemStack $itemStack)
    {
        return view('categories.itemStacks.show', [
            'category' => $category,
            'itemStack' => $itemStack
        ]);
    }
}