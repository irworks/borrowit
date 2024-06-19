@extends('layouts.page')

@section('page-content')
    <h1>@lang('reservation.list')</h1>
    <p>@lang('reservation.list-description')</p>

    <x-delete-section></x-delete-section>

    <table class="table align-middle">
        <thead class="table-dark text-uppercase">
            <th>#</th>
            <th>@lang('reservation.duration')</th>
            <th>@lang('reservation.user')</th>
            <th class="d-none d-md-table-cell">@lang('reservation.organisation')</th>
            <th>@lang('reservation.item-list')</th>
            <th>@lang('general.action')</th>
        </thead>

        <tbody>
            @foreach($reservations as $reservation)
                <tr class="@if($reservation->isFulfilled()) inactive @endif">
                    <td>{{ $reservation->id }}</td>
                    <td class="text-center">
                        <span class="badge bg-primary rounded-pill">
                            {{ $reservation->from->diffInDays($reservation->to) }} @lang('general.days')
                        </span><br>
                        {{ $reservation->from->format('d.m.y H:i') }}<br>{{ $reservation->to->format('d.m.y H:i') }}
                    </td>
                    <td>
                        {{ $reservation->user->name }}
                        <div class="d-block d-md-none">
                            <small>{{ $reservation->organisation?->name }}</small>
                        </div>
                    </td>
                    <td class="d-none d-md-table-cell">{{ $reservation->organisation->name ?? __('general.none') }}</td>
                    <td>
                        {{ $reservation->itemStackNamesString() }}
                    </td>
                    <td>
                        <a class="btn btn-primary @if($reservation->isFulfilled()) disabled @endif"
                           href="{{ route('reservations.collect', ['reservation' => $reservation]) }}">
                            <i class="bi bi-qr-code-scan"></i> @lang('reservation.collect')
                        </a>

                        <form class="mt-1" method="post" action="{{ route('reservations.cancel', ['reservation' => $reservation]) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-danger @if($reservation->isFulfilled()) disabled @endif"
                               href="{{ route('reservations.collect', ['reservation' => $reservation]) }}">
                                <i class="bi bi-x-circle"></i> @lang('reservation.cancel')
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
