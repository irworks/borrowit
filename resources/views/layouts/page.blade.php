@extends('layouts.app')

@section('meta-title'){{ config('app.name') }}@endsection
@section('meta-description'){{ config('app.description') }}@endsection
@section('meta-keywords'){{ config('app.keywords') }}@endsection

@section('content')
    <div class="container container-fluid">
        @yield('page-content')
    </div>
@endsection

@section('footer-value')
    <b>app name</b>,
    <small>
        <b>v:</b> {{ config('app.version.branch') }}-{{ config('app.version.commit') }}
    </small>
@endsection
