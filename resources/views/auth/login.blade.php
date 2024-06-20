@extends('auth.auth-page')

@section('auth-content')
    <div class="card-header border-0 bg-primary text-secondary">{{ __('Login') }}</div>

    <div class="card-body">
        <div class="d-flex justify-content-center align-items-center gap-2">
            <i class="fs-1 bi bi-box-arrow-in-right"></i> <span class="fs-5">{{ config('app.name') }}</span>
        </div>

        <form class="mt-4" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                <div class="col-md-6">
                    <input placeholder="email@example.com" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                <div class="col-md-6">
                    <input placeholder="password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 offset-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Login') }} <i class="bi bi-box-arrow-in-right"></i>
                    </button>

                    @if (Route::has('password.request'))
                        <a class="ms-3 icon-link icon-link-hover" href="{{ route('password.request') }}">
                            <span>{{ __('Forgot Your Password?') }}</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
@endsection
