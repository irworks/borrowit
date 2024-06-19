@extends('layouts.page')

@section('page-content')
    <h1>@lang('dashboard.title')</h1>

    <div class="row d-flex justify-content-center">
        <x-dashboard.box icon="bi-bag-dash" :value="$openReservations->count()" :route="route('reservations.index')">
            @lang('reservation.list-open')
        </x-dashboard.box>

        <x-dashboard.box icon="bi-cart-dash" :value="$openBookings->count()" :route="route('booking.index')">
            @lang('booking.list-open')
        </x-dashboard.box>

        <x-dashboard.box icon="bi-people" :value="$users->count()" :route="route('users.index')">
            @lang('user.list')
        </x-dashboard.box>
    </div>

    @if($openBookings->count() > 0)
        <h3 class="mt-4">@lang('booking.list-booked')</h3>
        <table class="table align-middle">
            <thead class="table-dark text-uppercase">
            <th>#</th>
            <th>@lang('item-stack.name')</th>
            <th>@lang('reservation.from')</th>
            <th>@lang('reservation.to')</th>
            <th>@lang('reservation.user')</th>
            <th>@lang('reservation.organisation')</th>
            </thead>

            <tbody>
            @foreach($openBookings as $booking)
                @foreach($booking->items as $bookingItem)
                    <tr>
                        <td>{{ $bookingItem->id }}</td>
                        <td>{{ $bookingItem->item->name }}</td>
                        <td>{{ $booking->from }}</td>
                        <td>{{ $booking->to }}</td>
                        <td>{{ $booking->user->name }}</td>
                        <td>{{ $booking->organisation ?? __('general.none') }}</td>
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
