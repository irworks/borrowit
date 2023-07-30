@props(['organisation' => null])
<tr>
    <td>
        {{ $organisation->id ?? '' }}

        <form method="post" id="org-{{ $organisation->id ?? 0 }}"
              action="@if(empty($organisation)) {{ route('organisations.store') }} @else {{ route('organisations.update', ['organisation' => $organisation]) }} }} @endif"
        >
            @csrf
            @if(!empty($organisation))
                @method('PATCH')
            @endif
        </form>
    </td>
    <td>
        <input class="form-control" type="text" id="name" name="name" form="org-{{ $organisation->id ?? 0 }}"
                value="{{ $organisation->name ?? '' }}" placeholder="@lang('organisation.name')">
    </td>
    <td class="text-center">
        {{ $organisation?->users()->count() ?? '-' }}
    </td>
    <td>
        {{ $organisation->created_at ?? '-' }}
    </td>
    <td>
        <button type="submit" form="org-{{ $organisation->id ?? 0 }}" class="btn btn-primary">
            @if(empty($organisation))
                <i class="bi bi-save-fill"></i>
            @else
                <i class="bi bi-save"></i>
            @endif
        </button>

        @if(!empty($organisation))
            <form class="d-inline-block" method="post" action="{{ route('organisations.destroy', ['organisation' => $organisation]) }}">
                @csrf
                <button type="submit" class="btn btn-danger ms-2"><i class="bi bi-trash"></i></button>
            </form>
        @endif
    </td>
</tr>