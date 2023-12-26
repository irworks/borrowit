@extends('layouts.page')

@section('page-content')
    <h1>@lang('booking.list')</h1>
    <p>@lang('booking.list-description')</p>

    @if(count($bookings) <= 0)
        <div class="mt-4 d-flex w-100 justify-content-center align-items-center">
            <h2>@lang('booking.none-open')</h2>
        </div>
    @else
        <table class="table align-middle">
            <thead class="table-dark text-uppercase">
            <th>#</th>
            <th>@lang('reservation.from')</th>
            <th>@lang('reservation.to')</th>
            <th>@lang('reservation.user')</th>
            <th>@lang('reservation.organisation')</th>
            <th>@lang('general.action')</th>
            </thead>

            <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->from }}</td>
                    <td>{{ $booking->to }}</td>
                    <td>{{ $booking->user->name }}</td>
                    <td>{{ $booking->organisation ?? __('general.none') }}</td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('booking.return', ['booking' => $booking]) }}">
                            @lang('booking.return')
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
