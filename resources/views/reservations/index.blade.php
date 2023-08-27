@extends('layouts.page')

@section('page-content')
    <h1>@lang('reservation.list')</h1>
    <p>@lang('reservation.list-description')</p>

    <x-delete-section></x-delete-section>

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
            @foreach($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->id }}</td>
                    <td>{{ $reservation->from }}</td>
                    <td>{{ $reservation->to }}</td>
                    <td>{{ $reservation->user->name }}</td>
                    <td>{{ $reservation->organisation ?? __('general.none') }}</td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('reservations.collect', ['reservation' => $reservation]) }}">
                            @lang('reservation.collect')
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection