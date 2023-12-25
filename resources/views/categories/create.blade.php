@extends('layouts.page')

@section('page-content')
    <h1>@lang('category.create')</h1>

    <div class="bg-white p-3 shadow-sm">
        <form class="row g-3" action="{{ route('categories.store') }}" method="post">
            @csrf

            <div class="col-md-6">
                <label for="name" class="form-label"><i class="bi bi-tag"></i> @lang('category.name')</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">

                <div class="mt-2">
                    <input class="form-check-input" type="checkbox" value="true" id="is_organisation_required" name="is_organisation_required">
                    <label class="form-check-label" for="is_organisation_required">
                        @lang('category.is_organisation_required')
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <label for="description" class="form-label"><i class="bi bi-card-text"></i> @lang('category.description')</label>
                <textarea name="description" class="form-control" id="description" rows="3">{{ old('description') }}</textarea>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">@lang('category.save')</button>
            </div>
        </form>
    </div>
@endsection
