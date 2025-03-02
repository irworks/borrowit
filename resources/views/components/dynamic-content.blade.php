@props(['item'])
@if(!empty($item))
    @if($item->html)
        {!! $item->content !!}
    @else
        {{ $item->content }}
    @endif
@endif
