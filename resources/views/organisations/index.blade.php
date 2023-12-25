@extends('layouts.page')

@section('page-content')
    <h1>@lang('organisation.overview')</h1>
    <p>@lang('organisation.overview-description')</p>

    <x-delete-section></x-delete-section>

    <table class="table align-middle">
        <thead class="table-dark text-uppercase">
            <th>#</th>
            <th>@lang('organisation.name')</th>
            <th class="text-center">@lang('organisation.members')</th>
            <th>@lang('general.created-at')</th>
            <th>@lang('general.action')</th>
        </thead>

        <tbody>
            @can('create', \App\Models\Organisation::class)
                <x-organisation.form></x-organisation.form>
            @endcan

            @foreach($organisations as $organisation)
                <x-organisation.form :organisation="$organisation"></x-organisation.form>
            @endforeach
        </tbody>
    </table>

@endsection
