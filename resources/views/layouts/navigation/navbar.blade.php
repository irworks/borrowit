<nav class="navbar navbar-expand-md navbar-light bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/logo/borrow-it-logo.svg') }}" alt="{{ config('app.name') }} Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav ms-2 me-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('categories.index') }}">@lang('category.overview')</a>
                    </li>

                    @if(Auth::user()->role >= \App\Models\UserRole::Admin->value)
                        <li class="nav-item nav-item-admin">
                            <a class="nav-link" href="{{ route('users.index') }}">@lang('user.overview')</a>
                        </li>

                        <li class="nav-item nav-item-admin">
                            <a class="nav-link" href="{{ route('itemStacks.index') }}">@lang('item-stack.overview')</a>
                        </li>
                    @endif

                    @if(Auth::user()->role >= \App\Models\UserRole::Manager->value)
                        <li class="nav-item nav-item-admin">
                            <a class="nav-link" href="{{ route('reservations.index') }}">@lang('reservation.overview')</a>
                        </li>

                        <li class="nav-item nav-item-admin">
                            <a class="nav-link" href="{{ route('booking.index') }}">@lang('booking.overview')</a>
                        </li>
                    @endif
                @endauth
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">@lang('auth.login')</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">@lang('auth.register')</a>
                        </li>
                    @endif
                @else
                    @if(auth()->user()->hasCurrentReservation())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('reservation.edit') }}">
                                <i class="me-1 bi bi-calendar-plus"></i> @lang('reservation.current')
                            </a>
                        </li>
                    @endif

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                            @if(Auth::user()->role > \App\Models\UserRole::User->value)
                                <x-user-role class="ms-2" :role="Auth::user()->role"></x-user-role>
                            @endif

                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('profile.update') }}">
                                @lang('profile.title')
                            </a>

                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                @lang('auth.logout')
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
