@props(['title' => config('app.name'), 'icon' => '', 'iconColor' => ''])

<div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
        <i class="bi {{ $icon }} {{ $iconColor }}"></i>
        <strong class="ms-2 me-auto">{{ $title }}</strong>
        <small class="text-body-secondary">just now</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
        {{ $slot }}
    </div>
</div>
