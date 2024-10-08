@extends('layouts.page')

@section('page-content')
    <h1>@lang('item-stack.overview')</h1>
    <p>@lang('item-stack.overview-description')</p>

    <x-delete-section></x-delete-section>

    <table class="table align-middle">
        <thead class="table-dark text-uppercase">
            <th>#</th>
            <th>@lang('item-stack.image')</th>
            <th>@lang('item-stack.name')</th>
            <th>@lang('item-stack.is-set')</th>
            <th>@lang('item-stack.category')</th>
            <th>@lang('general.created-at')</th>
            <th>@lang('general.action')</th>
        </thead>

        <tbody>
                <x-item-stack.form :categories="$categories"></x-item-stack.form>
            @foreach($itemStacks as $itemStack)
                <x-item-stack.form :item-stack="$itemStack" :categories="$categories"></x-item-stack.form>
            @endforeach
        </tbody>
    </table>

@endsection
