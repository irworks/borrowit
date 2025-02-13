@props(['user' => null, 'roles' => []])
<tr @if(!$user?->active) class="table-active" @endif>
    <td>
        {{ $user->id ?? '' }}

        <form method="post" id="user-{{ $user->id ?? 0 }}"
              action="@if(empty($user)) {{ route('users.store') }} @else {{ route('users.update', ['user' => $user]) }} }} @endif"
        >
            @csrf
            @if(!empty($user))
                @method('PATCH')
            @endif
        </form>
    </td>
    <td>
        <label class="visually-hidden" for="name">@lang('user.name')</label>
        <input class="form-control" type="text" id="name" name="name" form="user-{{ $user->id ?? 0 }}"
                value="{{ $user->name ?? '' }}" placeholder="@lang('user.name')" required>
    </td>
    <td>
        <label class="visually-hidden" for="email">@lang('user.email')</label>
        <input class="form-control" type="email" id="email" name="email" form="user-{{ $user->id ?? 0 }}"
               value="{{ $user->email ?? '' }}" placeholder="@lang('user.email')" required>
    </td>
    <td>
        <label class="visually-hidden" for="phone">@lang('user.phone')</label>
        <input class="form-control" type="text" id="phone" name="phone" form="user-{{ $user->id ?? 0 }}"
               value="{{ $user->phone ?? '' }}" placeholder="@lang('user.phone')" required>
    </td>
    <td>
        <select class="form-select" aria-label="@lang('user.role')" name="role" form="user-{{ $user->id ?? 0 }}">
            @foreach($roles as $id => $role)
                <option @if($id == $user->role) selected @endif value="{{ $id }}">{{ $role }}</option>
            @endforeach
        </select>
    </td>
    <td>
        {{ $user->last_login_at_string }}
    </td>
    <td>
        @if(empty($user))
            -
        @elseif($user->active)
            <span class="badge bg-success rounded-pill">@lang('general.active')</span>
        @else
            <span class="badge bg-danger rounded-pill">@lang('general.inactive')</span>
        @endif
    </td>
    <td>
        {{ $user->created_at_string }}
    </td>
    <td>
        <button type="submit" form="user-{{ $user->id ?? 0 }}" class="btn btn-primary">
            @if(empty($user))
                <i class="bi bi-save-fill"></i>
            @else
                <i class="bi bi-save"></i>
            @endif
        </button>

        @if(!empty($user))
            <button type="submit" name="active" form="user-{{ $user->id ?? 0 }}" class="btn @if($user->active) btn-outline-danger @else btn-outline-success @endif" value="{{ $user->active ? 'false' : 'true' }}">
                @if($user->active)
                    <i class="bi bi-person-fill-dash"></i>
                @else
                    <i class="bi bi-person-fill-check"></i>
                @endif
            </button>

            <button type="button" class="btn btn-danger ms-2"
                    data-bs-toggle="modal" onclick="document.getElementById('deleteForm').action = '{{ route('users.destroy', ['user' => $user]) }}'"
                    data-bs-target="#deleteModal"><i class="bi bi-trash"></i></button>
        @endif
    </td>
</tr>
