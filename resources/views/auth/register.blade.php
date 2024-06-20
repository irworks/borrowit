@extends('auth.auth-page')

@section('auth-content')
    <div class="card-header border-0 bg-primary text-secondary">{{ __('Register') }}</div>

    <div class="card-body">
        <div class="d-flex justify-content-center align-items-center gap-2">
            <i class="fs-1 bi bi-person-add"></i> <span class="fs-5">{{ config('app.name') }}</span>
        </div>

        <form class="mt-4" method="POST" action="{{ route('register') }}">
            @csrf

            <div class="row mb-3">
                <label for="name"
                       class="col-md-4 col-form-label text-md-end">{{ __('profile.name') }}</label>

                <div class="col-md-6">
                    <input id="name" type="text"
                           class="form-control @error('name') is-invalid @enderror" name="name"
                           value="{{ old('name') }}" required autocomplete="name" autofocus>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="email"
                       class="col-md-4 col-form-label text-md-end">{{ __('profile.email') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email"
                           class="form-control @error('email') is-invalid @enderror" name="email"
                           value="{{ old('email') }}" required autocomplete="email">

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="password"
                       class="col-md-4 col-form-label text-md-end">{{ __('profile.password') }}</label>

                <div class="col-md-6">
                    <input id="password" type="password"
                           class="form-control @error('password') is-invalid @enderror" name="password"
                           required autocomplete="new-password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="password-confirm"
                       class="col-md-4 col-form-label text-md-end">{{ __('profile.confirm-password') }}</label>

                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control"
                           name="password_confirmation" required autocomplete="new-password">
                </div>
            </div>

            <div class="row mb-3">
                <label for="phone"
                       class="col-md-4 col-form-label text-md-end">{{ __('profile.phone') }}</label>

                <div class="col-md-6">
                    <input id="phone" type="text"
                           class="form-control @error('phone') is-invalid @enderror" name="phone"
                           value="{{ old('phone') }}" required autocomplete="phone" autofocus>

                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Register') }}
                    </button>

                    <a class="btn btn-link" href="{{ route('login') }}">
                        {{ __('Got an account? Go to Login') }}
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
