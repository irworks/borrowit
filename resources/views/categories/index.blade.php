@extends('layouts.page')

@section('page-content')
    @foreach($categories as $category)
        <div class="mt-3">
            <b class="fs-3 pe-2">{{ $category->name }}</b>

            <a class="border-start ps-2 icon-link icon-link-hover" href="{{ route('categories.show', ['category' => $category]) }}">
                @lang('general.view-all')
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-square" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm4.5 5.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                </svg>
            </a>
        </div>

        <div class="mt-2 d-flex gap-3">
            @foreach($category->topItemStacks as $itemStack)
                <x-item-box :name="$itemStack->name" :image="$itemStack->image_uri"></x-item-box>
            @endforeach
        </div>
    @endforeach
@endsection