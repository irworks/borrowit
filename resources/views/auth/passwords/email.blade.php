@extends('auth.auth-page')

@section('auth-content')
    <div class="card-header border-0 bg-primary text-secondary">{{ __('Reset Password') }}</div>

    <div class="card-body">
        <div class="d-flex justify-content-center align-items-center gap-2">
            <i class="fs-1 bi bi-key"></i> <span class="fs-5">{{ config('app.name') }}</span>
        </div>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form class="mt-3" method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="row mb-3">
                <label for="email"
                       class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email"
                           class="form-control @error('email') is-invalid @enderror" name="email"
                           value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Send Password Reset Link') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
