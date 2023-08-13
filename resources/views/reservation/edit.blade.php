@extends('layouts.page')

@section('addition-scripts')
    @vite(['resources/js/reservation.js'])
@endsection

@section('page-content')
    <h1>@lang('reservation.title')</h1>
    <p>@lang('reservation.description')</p>

    <div id="reservation-app">
        <form method="post" action="{{ route('reservation.submit') }}">
            @csrf

            <div class="row">

                <div class="col-6">
                    <label for="from" class="form-label"><i class="bi bi-calendar-event"></i> @lang('reservation.from')</label>
                    <input type="datetime-local" class="form-control" name="from" id="from" value="{{ $reservation->from->format('Y-m-d\TH:i') }}">

                    <label for="to" class="form-label"><i class="bi bi-calendar2-event"></i> @lang('reservation.to')</label>
                    <input type="datetime-local" class="form-control" name="to" id="to" value="{{ $reservation->to->format('Y-m-d\TH:i') }}">
                </div>

                <div class="col-6">
                    <ul class="placeholder-glow list-group">
                        <div v-if="loading">
                            @foreach($items as $item)
                                <li class="list-group-item">
                                    <span class="placeholder col-12"></span>
                                </li>
                            @endforeach
                        </div>

                        <div v-else>
                            <li v-for="item in items"
                                class="list-group-item d-flex justify-content-between align-items-center"
                                :class="{ 'bg-danger text-light': !item.available }">
                                <div>
                                    @{{ item.item.name }}
                                    <div v-if="!item.available && (item.total - item.reserved - item.booked) > 0">
                                        <small><b>@{{ item.total - item.reserved - item.booked }}</b> @lang('reservation.would-be-available')</small>
                                    </div>
                                </div>

                                <span class="badge bg-primary rounded-pill">@{{ item.quantity }} @lang('general.pieces')</span>
                            </li>
                        </div>
                    </ul>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" :class="{disabled: !valid}">
                        @lang('reservation.submit')
                    </button>
                </div>

            </div>
        </form>
    </div>
@endsection
