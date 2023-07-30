@extends('layouts.page')

@section('page-content')
    <h1>@lang('users.overview')</h1>
    <p>@lang('users.overview-description')</p>

    <x-delete-section></x-delete-section>

    <table class="table align-middle text-uppercase">
        <thead class="table-dark">
            <th>#</th>
            <th>@lang('user.name')</th>
            <th>@lang('user.email')</th>
            <th>@lang('user.phone')</th>
            <th>@lang('user.role')</th>
            <th>@lang('user.last-login')</th>
            <th>@lang('user.active')</th>
            <th>@lang('general.created-at')</th>
            <th>@lang('general.action')</th>
        </thead>

        <tbody>
            @foreach($users as $user)
                <x-user.form :user="$user" :roles="$roles"></x-user.form>
            @endforeach
        </tbody>
    </table>

@endsection