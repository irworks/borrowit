@extends('layouts.page')

@section('page-content')
    @can('create')
        <div class="p-3 alert alert-info">
            <h5>@lang('general.admin-options')</h5>
            <button class="btn btn-primary"><i class="bi bi-journal-plus"></i> @lang('category.new')</button>
        </div>
    @endcan

    @foreach($categories as $category)
        <div class="mt-3">
            <b class="fs-3 pe-2">{{ $category->name }}</b>

            <a class="border-start ps-2 pe-2 icon-link icon-link-hover" href="{{ route('categories.show', ['category' => $category]) }}">
                @lang('general.show-all')
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-square" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm4.5 5.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                </svg>
            </a>

            @can('update', $category)
                <a class="border-start ps-2 icon-link icon-link-hover" href="{{ route('categories.edit', ['category' => $category]) }}">
                    @lang('general.edit')
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                    </svg>
                </a>
            @endcan
        </div>

        <div class="mt-2 d-flex gap-3">
            @foreach($category->topItemStacks as $itemStack)
                <x-item-box :name="$itemStack->name" :image="$itemStack->image_uri"></x-item-box>
            @endforeach
        </div>
    @endforeach
@endsection