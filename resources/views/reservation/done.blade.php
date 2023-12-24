@extends('layouts.page')

@section('page-content')
    <div class="text-center">
        <div><i class="bi bi-check-circle fs-1 text-primary"></i></div>
        <h1>@lang('reservation.thank-you')</h1>
        <p>
            @lang('reservation.reservation-complete')
        </p>
    </div>
@endsection
