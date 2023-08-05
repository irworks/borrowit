@extends('layouts.page')

@section('page-content')
    <h1>@lang('profile.title')</h1>
    <p>@lang('profile.description')</p>

    <div class="bg-white p-3 shadow-sm">
        <form class="row g-3" action="{{ route('profile.update') }}" method="post">
            @csrf
            <div class="col-md-6">
                <label for="email" class="form-label"><i class="bi bi-envelope-at"></i> @lang('user.email')</label>
                <input type="email" class="form-control" id="email" disabled value="{{ $user->email }}">
            </div>
            <div class="col-md-6">
                <label for="phone" class="form-label"><i class="bi bi-telephone"></i> @lang('user.phone')</label>
                <input type="text" class="form-control" id="phone" value="{{ $user->phone }}" name="phone">
            </div>

            <div class="col-md-6">
                <label for="organisation_id" class="form-label"><i class="bi bi-people"></i> @lang('user.organisation')</label>
                <select class="form-select" aria-label="@lang('user.organisation')" name="organisation_id">
                    @foreach($organisations as $id => $organisation)
                        <option @if($id == $user->organisation_id) selected @endif value="{{ $id }}">{{ $organisation }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6"></div>

            <div class="col-12">
                <hr>

                <small>@lang('user.new-password-description')</small>

                <div class="row">
                    <div class="col-md-6">
                        <label for="new-password" class="form-label"><i class="bi bi-key"></i> @lang('user.new-password')</label>
                        <input type="password" class="form-control" id="new-password" name="new-password">
                    </div>

                    <div class="col-md-6">
                        <label for="new-password_confirmation" class="form-label"><i class="bi bi-key"></i> @lang('user.new-password-confirmation')</label>
                        <input type="password" class="form-control" id="new-password_confirmation" name="new-password_confirmation">
                    </div>
                </div>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">@lang('user.save-profile')</button>
            </div>
        </form>
    </div>

@endsection
