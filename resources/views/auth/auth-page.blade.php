@extends('layouts.app')

@section('content')
    <div class="auth-page-container">
        <div class="auth-page-container-inner">
            <div>
                <div class="card shadow shadow-sm border-0">
                    @yield('auth-content')
                </div>
            </div>
        </div>
    </div>
@endsection
