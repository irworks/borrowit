@extends('layouts.page')

@section('page-content')
    <h1>@lang('user.overview')</h1>
    <p>@lang('user.overview-description')</p>

    <x-delete-section />

    <form id="search" method="get">

    </form>

    <table class="table align-middle">
        <thead class="table-dark text-uppercase">
            <th class="align-text-top">#</th>
            <th>
                <label for="name">@lang('user.name')</label>
                <input class="form-control primary-lighter" type="text" id="name" name="name" form="search" value="{{ request('name') }}" placeholder="@lang('user.name-placeholder')">
            </th>
            <th>
                <label for="email">@lang('user.email')</label>
                <input class="form-control primary-lighter" type="text" id="email" name="email" form="search" value="{{ request('email') }}" placeholder="@lang('user.email-placeholder')">
            </th>
            <th>
                <label for="phone">@lang('user.phone')</label>
                <input class="form-control primary-lighter" type="text" id="phone" name="phone" form="search" value="{{ request('phone') }}" placeholder="@lang('user.phone-placeholder')">
            </th>
            <th>
                <label for="role">@lang('user.role')</label>
                <select class="form-select primary-lighter" aria-label="@lang('user.role')" name="role" form="search">
                    <option value="">-- @lang('auth.roles-all') --</option>
                    @foreach($roles as $id => $role)
                        <option value="{{ $id }}" @if(request('role') == $id) selected @endif>{{ $role }}</option>
                    @endforeach
                </select>
            </th>
            <th class="align-text-top">@lang('user.last-login')</th>
            <th>
                <label for="active">@lang('user.active')</label>
                <select class="form-select primary-lighter" aria-label="@lang('user.active')" name="active" form="search">
                    <option value="">-- @lang('auth.roles-all') --</option>
                    <option value="true" @if(request('active') === 'true') selected @endif>@lang('general.active')</option>
                    <option value="false" @if(request('active') === 'false') selected @endif>@lang('general.inactive')</option>
                </select>
            </th>
            <th class="align-text-top">@lang('general.created-at')</th>
            <th>
                @lang('general.action')
                <div>
                    <button type="submit" class="btn btn-light" form="search">
                        <i class="bi bi-funnel"></i> @lang('general.filter')
                    </button>
                </div>
            </th>
        </thead>

        <tbody>
            @foreach($users as $user)
                <x-user.form :user="$user" :roles="$roles"></x-user.form>
            @endforeach
        </tbody>
    </table>

@endsection
