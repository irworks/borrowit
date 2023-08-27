@extends('layouts.page')

@section('addition-scripts')
    <script>
        window.RESERVATION_ID = {{ $reservation->id }};
    </script>

    @vite(['resources/js/reservation-collector.js'])
@endsection

@section('page-content')
    @if($reservation->isFulfilled())
        <div class="text-center">
            <i class="bi bi-info-circle-fill fs-3"></i>
            <h1 class="mt-2">{{ __('reservation.already-fulfilled') }}</h1>

            <a class="btn btn-primary" href="{{ route('reservations.index') }}">
                <i class="bi bi-arrow-left"></i> @lang('general.back')
            </a>
        </div>
    @else
        <h1>@lang('reservation.title') #{{ $reservation->id }}</h1>
        <p>@lang('reservation.collect-description')</p>
        <div id="reservation-collector-app">
            <scanner v-if="currentView === 'scanner'"
                     @result="onScanComplete">
            </scanner>

            <b class="fs-5">@lang('reservation.list-itemStacks')</b>
            <ul class="placeholder-glow list-group">
                <div v-if="loading">
                    @foreach($reservation->reservationItemStacks as $item)
                        <li class="list-group-item">
                            <span class="placeholder col-12"></span>
                        </li>
                    @endforeach
                </div>

                <div v-else>
                    <li v-for="item in itemStacks"
                        class="list-group-item d-flex justify-content-between align-items-center"
                        :class="{ 'bg-success text-light': scannedItemStacks[item.meta.id]?.length == item.quantity }">
                        <div>
                            @{{ item.meta.name }}
                            <div v-if="listOfScannedItems(item.meta.id)?.length > 0">
                                <small>
                                    <b>@lang('booking.scanned'):</b> @{{ listOfScannedItems(item.meta.id) }}
                                </small>
                            </div>
                        </div>

                        <span class="badge bg-primary rounded-pill">@{{ scannedItemStacks[item.meta.id]?.length ?? 0 }} / @{{ item.quantity }} @lang('general.pieces')</span>
                    </li>
                </div>
            </ul>

            @if(!empty($reservation->notes))
                <div class="bg-white rounded shadow-sm my-2 p-4">
                    <h4>@lang('reservation.notes')</h4>
                    <p class="m-0">
                        {{ $reservation->notes }}
                    </p>
                </div>
            @endif

            <div class="mt-3 d-flex justify-content-end">
                <button @click="submit" class="btn" :class="isEverythingScanned ? 'btn-primary' : 'btn-warning'" :disabled="!isBookingValid">
                    @lang('booking.submit') <i class="bi bi-calendar2-check"></i>
                </button>
            </div>
        </div>
    @endif
@endsection