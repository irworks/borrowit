@extends('layouts.page')

@section('page-content')
    <x-delete-section :title="__('reservation.retract')">
        @lang('reservation.retract-description')
    </x-delete-section>

    <form method="get" id="search-form">
    </form>

        <div class="d-flex justify-content-between align-items-center">
            <h2>@lang('reservation.list-my')</h2>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="showOnlyOpenReservations" value="true"
                       form="search-form"
                       id="showOnlyOpenReservations" @if($showOnlyOpenReservations) checked
                       @endif onclick="this.form.submit();">
                <label class="form-check-label" for="showOnlyOpenReservations">
                    @lang('reservation.show-only-open')
                </label>
            </div>
        </div>

        @if(count($reservations) <= 0)
            <div class="mt-4 text-center">
                <h3 class="text-muted">@lang('reservation.none')</h3>
            </div>
        @endif

        @foreach($reservations as $reservation)
            <x-my-lists.rental type="reservation" :rental="$reservation"></x-my-lists.rental>
        @endforeach

        <div class="d-flex justify-content-between align-items-center">
            <h2 class="mt-4">@lang('booking.list-my')</h2>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="showOnlyOpenBookings" value="true"
                       id="showOnlyOpenBookings" @if($showOnlyOpenBookings) checked @endif
                       form="search-form"
                       onclick="this.form.submit();">
                <label class="form-check-label" for="showOnlyOpenBookings">
                    @lang('booking.show-only-open')
                </label>
            </div>
        </div>

        @if(count($bookings) <= 0)
            <div class="mt-4 text-center">
                <h3 class="text-muted">@lang('booking.none')</h3>
            </div>
        @endif

        @foreach($bookings as $booking)
            <x-my-lists.rental type="booking" :rental="$booking"></x-my-lists.rental>
        @endforeach
@endsection
