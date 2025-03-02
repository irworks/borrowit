@extends('auth.auth-page')

@section('auth-content')
    <div class="card-header border-0 bg-primary text-secondary">{{ __('auth.verify-email') }}</div>

    <div class="card-body">
        <div class="d-flex justify-content-center align-items-center gap-2">
            <i class="fs-1 bi bi-envelope-check"></i> <span class="fs-5">{{ config('app.name') }}</span>
        </div>

        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif

        {{ __('Before proceeding, please check your email for a verification link.') }}
        {{ __('If you did not receive the email') }},
        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
        </form>
    </div>
@endsection
