@props(['role'])

<span {{ $attributes->merge(['class' => 'badge text-bg-secondary']) }}>@lang('auth.roles-' . $role)</span>