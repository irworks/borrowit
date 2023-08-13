<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Style and Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @yield('addition-scripts')
</head>
<body>
    <div id="app">
        @include('layouts.navigation.navbar')

        <main class="py-4">
            @if ($errors->any())
                <div class="toast-container top-end-corner">
                    @foreach($errors->all() as $error)
                        <x-toast :title="__('general.error')">
                            {{ $error }}
                        </x-toast>
                    @endforeach
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
