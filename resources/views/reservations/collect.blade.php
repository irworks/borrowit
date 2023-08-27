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
            <div v-if="currentView === 'main'" class="my-3 text-center">
                <button class="btn btn-primary" @click="openScanner">
                    <i class="bi bi-qr-code-scan"></i> @lang('general.open-scanner')
                </button>
            </div>

            <scanner v-if="currentView === 'scanner'"
                     @result="onScanComplete">
            </scanner>

            <b class="fs-5">@lang('reservation.list-itemStacks')</b>
            <item-stack-list :item-stacks="itemStacks"
                             :scanned-item-stacks="scannedItemStacks"
                             :count-placeholders="{{ $reservation->reservationItemStacks()->count() }}"
                             :loading="loading"
                             pieces="{{ __('general.pieces') }}"
                             scanned="{{ __('general.scanned') }}"
            >
            </item-stack-list>

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
                    @lang('booking.submit') <i class="ms-1 bi bi-calendar2-check"></i>
                </button>
            </div>
        </div>
    @endif
@endsection