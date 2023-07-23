@extends('layouts.page')

@section('page-content')
    <h1>{{ $category->name }}</h1>
    <p>{{ $category->description }}</p>

    <div class="mt-2 d-flex gap-3">
        @foreach($category->itemStacks as $itemStack)
            <x-item-box :name="$itemStack->name" :image="$itemStack->image_uri"></x-item-box>
        @endforeach
    </div>
@endsection