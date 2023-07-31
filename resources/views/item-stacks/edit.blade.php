@extends('layouts.page')

@section('page-content')
    <h1>{{ __('items-stacks.edit') }}</h1>

    <x-delete-section></x-delete-section>

    <div class="bg-white shadow-sm">
        <div class="bg-primary text-light p-3">
            <b class="fs-4">{{ $itemStack->name }}</b>
        </div>

        <div class="p-3">
            <form action="{{ route('itemStacks.update', ['itemStack' => $itemStack]) }}" method="post">
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
                            <label for="formFile" class="form-label">Default file input example</label>
                            <input class="form-control" type="file" id="formFile">
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
                        <i class="bi bi-save"></i> @lang('itemStack.save')
                    </button>
                </div>
            </form>
        </div>

        <hr>

        <div class="p-3">
            @if($itemStack->items()->count() <= 0)
                <h4 class="text-center">@lang('item-stack.no-items')</h4>
            @else
                <h4>@lang('item-stack.items')</h4>
                @foreach($itemStack->items as $item)

                @endforeach
            @endif
        </div>
    </div>
@endsection