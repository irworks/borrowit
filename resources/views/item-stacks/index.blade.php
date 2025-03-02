@extends('layouts.page')

@section('page-content')
    <h1>@lang('item-stack.overview')</h1>
    <p>@lang('item-stack.overview-description')</p>

    <x-delete-section></x-delete-section>

    <form id="search" method="get">

    </form>

    <table class="table align-middle">
        <thead class="table-dark text-uppercase">
            <th class="align-text-top">#</th>
            <th class="align-text-top">@lang('item-stack.image')</th>
            <th>
                <label for="name">@lang('item-stack.name')</label>
                <input class="form-control primary-lighter" type="text" id="name" name="name" form="search" value="{{ request('name') }}" placeholder="@lang('item-stack.name-placeholder')">
            </th>
            <th class="align-text-top">@lang('item-stack.is-set')</th>
            <th>
                <label for="role">@lang('item-stack.category')</label>
                <select class="form-select primary-lighter" aria-label="@lang('item-stack.category')" name="category" form="search">
                    <option value="">-- @lang('category.all') --</option>
                    @foreach($categories as $id => $category)
                        <option value="{{ $id }}" @if(request('category') == $id) selected @endif>{{ $category }}</option>
                    @endforeach
                </select>
            </th>
            <th class="align-text-top">@lang('general.created-at')</th>
            <th>
                @lang('general.action')
                <div>
                    <button type="submit" class="btn btn-light" form="search">
                        <i class="bi bi-funnel"></i> @lang('general.filter')
                    </button>
                </div>
            </th>
        </thead>

        <tbody>
                <x-item-stack.form :categories="$categories"></x-item-stack.form>
            @foreach($itemStacks as $itemStack)
                <x-item-stack.form :item-stack="$itemStack" :categories="$categories"></x-item-stack.form>
            @endforeach
        </tbody>
    </table>

@endsection
