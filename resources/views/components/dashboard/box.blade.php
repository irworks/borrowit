@props(['icon' => '', 'value' => 0, 'route', 'wrapperClasses' => 'col-4 col-md-2'])

<div class="{{ $wrapperClasses }}">
    @if(!empty($route))
        <a href="{{ $route }}" class="text-decoration-none">
            @endif


            <div class="card position-relative p-4 h-100 bg-primary border-0 shadow shadow-sm">
                <i class="position-absolute top-0 start-075 fw-bold fs-1 bi text-secondary {{ $icon }}"></i>

                <div class="d-flex flex-column justify-content-center align-items-center h-100 placeholder-glow zoom-hover">
                    <div class="fw-bold fs-1 text-light ">{{ $value }}</div>
                    <div class="text-darker">
                        {{ $slot }}
                    </div>
                </div>
            </div>

            @if(!empty($route))
        </a>
    @endif

</div>
