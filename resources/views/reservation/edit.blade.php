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

                <div class="col-12 col-md-5">
                    <label for="from" class="form-label"><i class="bi bi-calendar-event"></i> @lang('reservation.from')</label>
                    <input type="datetime-local" v-model="from" @change="updateTimes" class="form-control" name="from" id="from">

                    <div class="mt-2">
                        <label for="to" class="form-label"><i class="bi bi-calendar2-event"></i> @lang('reservation.to')
                        </label>
                        <input type="datetime-local" v-model="to" @change="updateTimes" class="form-control"
                               :class="{'is-invalid' : error}" name="to" id="to">

                        <div v-if="error" class="invalid-feedback">
                            @{{ errorMessage }}
                        </div>
                    </div>
                </div>

                <div class="col-0 col-md-1"></div>

                <div class="col-12 col-md-6 mt-3 mt-md-0">
                    <span><i class="bi bi-card-list"></i> @lang('reservation.items')</span>

                    <ul class="mt-2 placeholder-glow list-group">
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

                                <div>
                                    <button class="btn" @click.prevent="decreaseQuantity(item)">-</button>
                                    <span class="badge bg-primary rounded-pill">@{{ item.quantity }} @lang('general.pieces')</span>
                                    <button class="btn border-0" @click.prevent="increaseQuantity(item)" :disabled="item.quantity >= item.total">+</button>
                                </div>
                            </li>
                        </div>
                    </ul>
                </div>

                <div class="mt-2 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" :class="{disabled: !valid}">
                        @lang('reservation.submit')
                    </button>
                </div>

            </div>
        </form>
    </div>
@endsection
