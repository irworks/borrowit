@props(['item' => null, 'itemStack' => null])
<tr>
    <td>
        {{ $item->id ?? '' }}

        <form method="post" id="item-{{ $item->id ?? 0 }}"
              action="@if(empty($item)) {{ route('items.store', ['itemStack' => $itemStack]) }} @else {{ route('items.update', ['itemStack' => $itemStack, 'item' => $item]) }} }} @endif"
        >
            @csrf
            @if(!empty($item))
                @method('PATCH')
            @endif
        </form>
    </td>
    <td>
        <input type="hidden" name="item_stack_id" form="item-{{ $item->id ?? 0 }}"
               value="{{ $itemStack->id ?? '' }}">

        <label class="visually-hidden" for="name">@lang('item.name')</label>
        <input class="form-control" type="text" id="name" name="name" form="item-{{ $item->id ?? 0 }}"
                value="{{ $item->name ?? '' }}" placeholder="@lang('item.name')" required>
    </td>
    <td>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="true" id="is_intact" name="is_intact" @if($item->is_intact ?? false) checked @endif form="item-{{ $item->id ?? 0 }}">
            <label class="form-check-label" for="is_intact">
                @lang('item.is-intact')
            </label>
        </div>
    </td>
    <td>
        {{ $item->created_at ?? '-' }}
    </td>
    <td>
        <button type="submit" form="item-{{ $item->id ?? 0 }}" class="btn btn-primary">
            @if(empty($item))
                <i class="bi bi-save-fill"></i>
            @else
                <i class="bi bi-save"></i>
            @endif
        </button>

        @if(!empty($item))
            <a href="{{ route('items.edit', ['item' => $item, 'itemStack' => $itemStack]) }}" type="button" class="btn btn-primary ms-2">
                <i class="bi bi-pencil-square"></i>
            </a>

            <a href="{{ route('items.qr', ['item' => $item, 'itemStack' => $itemStack]) }}" type="button" class="btn btn-primary ms-2">
                <i class="bi bi-qr-code"></i>
            </a>

            <button type="button" class="btn btn-danger ms-2"
                    data-bs-toggle="modal" onclick="document.getElementById('deleteForm').action = '{{ route('items.destroy', ['item' => $item, 'itemStack' => $itemStack]) }}'"
                    data-bs-target="#deleteModal"><i class="bi bi-trash"></i></button>
        @endif
    </td>
</tr>
