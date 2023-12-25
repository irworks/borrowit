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

        $data = $request->validated();
        $data['is_organisation_required'] = $request->has('is_organisation_required');

        $category = Category::create($data);
        return redirect(route('categories.show', ['category' => $category]));
    }

    public function edit(Category $category)
    {
        $this->authorize('update', $category);

        return view('categories.edit', ['category' => $category]);
    }

    public function create()
    {
        $this->authorize('create', Category::class);

        return view('categories.create');
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $this->authorize('update', $category);

        $data = $request->validated();
        $data['is_organisation_required'] = $request->has('is_organisation_required');

        $category->update($data);

        return redirect(route('categories.show', ['category' => $category]));
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

        $category->delete();

        return redirect(route('categories.index'));
    }
}
