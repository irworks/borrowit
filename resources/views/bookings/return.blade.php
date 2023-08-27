@extends('layouts.page')

@section('addition-scripts')
    <script>
        window.BOOKING_ID = {{ $booking->id }};
    </script>

    @vite(['resources/js/booking-returner.js'])
@endsection

@section('page-content')
    @if($booking->isReturned())
        <div class="text-center">
            <i class="bi bi-info-circle-fill fs-3"></i>
            <h1 class="mt-2">{{ __('booking.already-returned') }}</h1>

            <a class="btn btn-primary" href="{{ route('booking.index') }}">
                <i class="bi bi-arrow-left"></i> @lang('general.back')
            </a>
        </div>
    @else
        <h1>@lang('booking.title') #{{ $booking->id }}</h1>
        <p>@lang('booking.return-description')</p>
        <div id="booking-return-app">
            <item-scan-app
                      :item-stacks="itemStacks"
                      :loading="loading"
                      pieces-label="{{ __('general.pieces') }}"
                      scanned-label="{{ __('general.scanned') }}"
                      submit-label="{{ __('booking.return') }}"
                      list-label="{{ __('booking.list-booked') }}"
                      open-scanner-label="{{ __('general.open-scanner') }}"
                      list-item-stacks-label="{{ __('general.list-itemStacks') }}"
                      @submit="submit"
            >
                @if(!empty($booking->notes))
                    <div class="bg-white rounded shadow-sm my-2 p-4">
                        <h4>@lang('reservation.notes')</h4>
                        <p class="m-0">
                            {{ $booking->notes }}
                        </p>
                    </div>
                @endif
            </item-scan-app>
        </div>
    @endif
@endsection