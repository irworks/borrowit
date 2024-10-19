@extends('layouts.page')

@section('page-content')
    <h1>{{ __('item-stack.edit') }}</h1>

    <x-delete-section></x-delete-section>

    <div class="bg-white shadow-sm">
        <div class="bg-primary text-light p-3">
            <b class="fs-4">{{ $itemStack->name }}</b>
        </div>

        <div class="p-3">
            <form enctype="multipart/form-data" action="{{ route('itemStacks.update', ['itemStack' => $itemStack]) }}"
                  method="post">
                @csrf
                @method('PATCH')

                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">@lang('item-stack.name')</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="" value="{{ old('name') ?? $itemStack->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">@lang('item-stack.description')</label>
                            <textarea name="description" class="form-control" id="description" rows="3">{{ old('description') ?? $itemStack->description }}</textarea>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="mb-3">
                            @if($itemStack->hasImage())
                                <div class="row align-items-end">
                                    <div class="col-6">
                                        <img class="item-stack-image" src="{{ $itemStack->image_uri }}" alt="{{ $itemStack->name }}">
                                    </div>
                                    <div class="col-6">
                            @endif

                            <label for="image" class="form-label">@lang('item-stack.image')</label>
                            <input class="form-control" type="file" id="image" name="image">

                            @if($itemStack->hasImage())
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">@lang('item-stack.category')</label>
                            <select class="form-select" id="category_id" aria-label="@lang('item-stack.category')" name="category_id">
                                @foreach($categories as $id => $category)
                                    <option @if($id == $itemStack->category_id) selected @endif value="{{ $id }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="true" id="is_set" @if($itemStack->is_set) checked @endif form="item-stack-{{ $itemStack->id ?? 0 }}">
                                <label class="form-check-label" for="is_set">
                                    @lang('item-stack.is-set')
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> @lang('item-stack.save')
                    </button>
                </div>
            </form>
        </div>

        <hr>

        <div>
            @if($itemStack->items()->count() <= 0)
                <h4 class="p-3text-center">@lang('item-stack.no-items')</h4>
            @else
                <h4 class="p-3">@lang('item-stack.items')</h4>
                <table class="table align-middle">
                    <thead class="table-dark text-uppercase">
                    <th>#</th>
                    <th>@lang('item.name')</th>
                    <th>@lang('item.is-intact')</th>
                    <th>@lang('general.created-at')</th>
                    <th>@lang('general.action')</th>
                    </thead>

                    <tbody>
                    <x-item.form :item-stack="$itemStack"></x-item.form>
                    @foreach($itemStack->items as $item)
                        <x-item.form :item="$item" :item-stack="$itemStack"></x-item.form>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
