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
            <item-scan-app
                      :item-stacks="itemStacks"
                      :loading="loading"
                      pieces-label="{{ __('general.pieces') }}"
                      scanned-label="{{ __('general.scanned') }}"
                      submit-label="{{ __('booking.submit') }}"
                      open-scanner-label="{{ __('general.open-scanner') }}"
                      list-item-stacks-label="{{ __('general.list-itemStacks') }}"
                      @submit="submit"
            >
                @if(!empty($reservation->notes))
                    <div class="bg-white rounded shadow-sm my-2 p-4">
                        <h4>@lang('reservation.notes')</h4>
                        <p class="m-0">
                            {{ $reservation->notes }}
                        </p>
                    </div>
                @endif

                <div class="mt-2 text-center" v-if="error">
                    <span class="text-danger"><i class="bi bi-exclamation-circle"></i> @{{ errorMessage }}</span>
                </div>
            </item-scan-app>
        </div>
    @endif
@endsection
