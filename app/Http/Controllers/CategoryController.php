<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return view('categories.index', ['categories' => Category::all()]);
    }

    public function show(Category $category)
    {
        return view('categories.itemStacks.index', ['category' => $category]);
    }

    public function store(CategoryRequest $request)
    {
        $this->authorize('create', Category::class);

        return Category::create($request->validated());
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $this->authorize('update', $category);

        $category->update($request->validated());

        return $category;
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

        $category->delete();

        return response()->json();
    }
}
