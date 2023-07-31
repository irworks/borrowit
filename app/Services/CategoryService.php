<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function selectArray(): array
    {
        return Category::all()->pluck('name', 'id')->toArray();
    }
}