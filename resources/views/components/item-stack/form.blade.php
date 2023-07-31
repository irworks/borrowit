@props(['itemStack' => null, 'categories' => []])
<tr>
    <td>
        {{ $itemStack->id ?? '' }}

        <form method="post" id="item-stack-{{ $itemStack->id ?? 0 }}"
              action="@if(empty($itemStack)) {{ route('itemStacks.store') }} @else {{ route('itemStacks.update', ['itemStack' => $itemStack]) }} }} @endif"
        >
            @csrf
            @if(!empty($itemStack))
                @method('PATCH')
            @endif
        </form>
    </td>
    <td>
        <img style="max-height: 50px;" src="{{ $itemStack->image_uri ?? '' }}" alt="{{ $itemStack->name ?? __('item-stack.empty-image') }}">
    </td>
    <td>
        <label class="visually-hidden" for="name">@lang('item-stack.name')</label>
        <input class="form-control" type="text" id="name" name="name" form="item-stack-{{ $itemStack->id ?? 0 }}"
                value="{{ $itemStack->name ?? '' }}" placeholder="@lang('item-stack.name')" required>
    </td>
    <td>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="true" id="is_set" name="is_set" @if($itemStack->is_set ?? false) checked @endif form="item-stack-{{ $itemStack->id ?? 0 }}">
            <label class="form-check-label" for="is_set">
                @lang('item-stack.is-set')
            </label>
        </div>
    </td>
    <td>
        <select class="form-select" aria-label="@lang('item-stack.category')" name="category_id" form="item-stack-{{ $itemStack->id ?? 0 }}">
            @foreach($categories as $id => $category)
                <option @if(!empty($itemStack) && $id == $itemStack->category_id) selected @endif value="{{ $id }}">{{ $category }}</option>
            @endforeach
        </select>
    </td>
    <td>
        {{ $itemStack->created_at ?? '-' }}
    </td>
    <td>
        <button type="submit" form="item-stack-{{ $itemStack->id ?? 0 }}" class="btn btn-primary">
            @if(empty($itemStack))
                <i class="bi bi-save-fill"></i>
            @else
                <i class="bi bi-save"></i>
            @endif
        </button>

        @if(!empty($itemStack))
            <a href="{{ route('itemStacks.edit', ['itemStack' => $itemStack]) }}" type="button" class="btn btn-primary ms-2">
                <i class="bi bi-three-dots-vertical"></i>
            </a>

            <button type="button" class="btn btn-danger ms-2"
                    data-bs-toggle="modal" onclick="document.getElementById('deleteForm').action = '{{ route('itemStacks.destroy', ['itemStack' => $itemStack]) }}'"
                    data-bs-target="#deleteModal"><i class="bi bi-trash"></i></button>
        @endif
    </td>
</tr>