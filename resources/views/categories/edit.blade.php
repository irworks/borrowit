@extends('layouts.page')

@section('page-content')
    <h1>{{ $category->name }}</h1>

    <x-delete-section :title="$category->name"></x-delete-section>

    <div class="bg-white p-3 shadow-sm">
        <form class="row g-3" action="{{ route('categories.update', ['category' => $category]) }}" method="post">
            @csrf
            @method('PATCH')

            <div class="col-md-6">
                <label for="name" class="form-label"><i class="bi bi-tag"></i> @lang('category.name')</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ $category->name }}">

                <div class="mt-2">
                    <input class="form-check-input" type="checkbox" value="true" id="is_organisation_required" name="is_organisation_required" @if($category->is_organisation_required ?? false) checked @endif">
                    <label class="form-check-label" for="is_organisation_required">
                        @lang('category.is_organisation_required')
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <label for="description" class="form-label"><i class="bi bi-card-text"></i> @lang('category.description')</label>
                <textarea name="description" class="form-control" id="description" rows="3">{{ old('description') ?? $category->description }}</textarea>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">@lang('category.save')</button>

                <button type="button" class="btn btn-danger ms-2"
                        data-bs-toggle="modal" onclick="document.getElementById('deleteForm').action = '{{ route('categories.destroy', ['category' => $category]) }}'"
                        data-bs-target="#deleteModal"><i class="bi bi-trash"></i>
                </button>
            </div>
        </form>
    </div>
@endsection
