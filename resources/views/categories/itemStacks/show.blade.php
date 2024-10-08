@extends('layouts.page')

@section('addition-scripts')
    @vite(['resources/js/item-stack-show.js'])
@endsection

@section('page-content')
    <div class="mb-3">
        <a class="ps-2 pe-2 icon-link icon-link-hover border-end" href="{{ route('categories.show', ['category' => $category]) }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm11.5 5.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
            </svg>

            @lang('general.back')
        </a>

        <b class="ps-2">{{ $category->name }}</b>
    </div>

    <div class="row">
        <div class="col-12 col-md-8 mt-4 mt-md-0">
            <h1>{{ $itemStack->name }}</h1>

            <div class="row">
                @if($itemStack->hasImage())
                    <div class="col-3">
                        <img class="w-100" src="{{ $itemStack->image_uri }}" alt="{{ $itemStack->name }}">
                    </div>
                @endif

                <div class="@if($itemStack->hasImage()) col-9 @else col-12 @endif">
                    <p>
                        {!! nl2br($itemStack->description) !!}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4 mt-4 mt-md-0">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('reservation.add-item')</h5>
                    <p class="card-text">@lang('reservation.add-item-description')</p>

                    <form action="{{ route('reservation.add-itemstack') }}" method="post">
                        @csrf
                        <input type="hidden" name="item_stack_id" value="{{ $itemStack->id }}">

                        <script>
                            const ITEM_STACK_MAX_AMOUNT = {{ $itemStack->intactItems()->count() }};
                            const VUE_LANG = {
                                quantityLabel: "{{ __('item-stack.quantity') }}",
                                reserve: "{{ __('reservation.reserve') }}",
                            };
                        </script>
                        <div id="item-stack-show-app">
                            <input type="hidden" name="item_stack_id" value="{{ $itemStack->id }}">

                            @if($itemStack->intactItems()->count() > 1)
                                <label for="quantity" class="form-label">@lang('item-stack.quantity')</label>
                                <input type="range" class="form-range" name="quantity" min="1" max="{{ $itemStack->intactItems()->count() }}" id="quantity">
                            @else
                                <input type="hidden" name="quantity" value="1">
                            @endif

                            <button type="submit" class="btn btn-primary" @if($itemStack->intactItems()->count() <= 0) disabled @endif>
                                <i class="me-1 bi bi-calendar-plus"></i> @lang('reservation.reserve')
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <small class="text-body-secondary">{!! __('item-stack.amount-available', ['times' => $itemStack->intactItems()->count()]) !!}</small>
                </div>
            </div>

        </div>
    </div>
@endsection
