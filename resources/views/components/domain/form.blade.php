@props(['domain' => null])
<tr>
    <td>
        {{ $domain->id ?? '' }}

        <form method="post" id="domain-{{ $domain->id ?? 0 }}"
              action="@if(empty($domain)) {{ route('admin.settings.domain.store') }} @else {{ route('admin.settings.domain', ['domain' => $domain]) }} @endif"
        >
            @csrf
            @if(!empty($domain))
                @method('PATCH')
            @endif
        </form>
    </td>
    <td>
        <label class="visually-hidden" for="domain">@lang('domain.name')</label>
        <input class="form-control" type="text" id="domain" name="domain" form="domain-{{ $domain->id ?? 0 }}"
                value="{{ $domain->domain ?? '' }}" placeholder="@lang('domain.name-example')" required>
    </td>
    <td>
        @if(empty($domain))
            -
        @else
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="true" id="active" name="active" @if($domain->active ?? false) checked @endif form="domain-{{ $domain->id ?? 0 }}">
                <label class="form-check-label" for="active">
                    @lang('general.active')
                </label>
            </div>
        @endif
    </td>
    <td>
        <button type="submit" form="domain-{{ $domain->id ?? 0 }}" class="btn btn-primary">
            @if(empty($domain))
                <i class="bi bi-save-fill"></i>
            @else
                <i class="bi bi-save"></i>
            @endif
        </button>

        @if(!empty($domain))
            <button type="button" class="btn btn-danger ms-2"
                    data-bs-toggle="modal" onclick="document.getElementById('deleteForm').action = '{{ route('admin.settings.domain', ['domain' => $domain]) }}'"
                    data-bs-target="#deleteModal"><i class="bi bi-trash"></i></button>
        @endif
    </td>
</tr>
