@props(['name', 'image', 'href' => '#'])

<a class="item-box bg-white rounded shadow-sm text-decoration-none overflow-scroll" href="{{ $href }}">
    <div class="item-box-image-container">
        <img src="{{ $image }}" alt="{{ $name }}">
    </div>
    <div class="item-box-name px-2 pt-2">
        <b>{{ $name }}</b>
    </div>
</a>