@props(['type', 'rental'])

<div class="mt-2 @if(!$rental->isOpen()) bg-gray @else bg-white @endif p-3 shadow-sm">
    <div class="d-flex justify-content-between align-items-center">
        <h4>{{ __($type . '.one') }} #{{ $rental->id }}</h4>

        @if(!$rental->isOpen())
            <span class="d-none d-md-block badge bg-success rounded-pill">
                    {{ __($type . '.fulfilled', ['date' => $rental->finished_at->format('d.m.y H:i')]) }}
                </span>
        @endif

        <div class="text-end">
            <span class="badge bg-primary rounded-pill">
                {{ $rental->from->diffInDays($rental->to) }} @lang('general.days')
            </span>
            <br>
            <small class="text-muted">{{ $rental->from->format('d.m.y H:i') }}
                <i class="bi bi-arrow-right"></i>
                {{ $rental->to->format('d.m.y H:i') }}
            </small>

            @if(!$rental->isOpen())
                <span class="d-block d-md-none badge bg-success rounded-pill">
                        {{ __($type . '.fulfilled', ['date' => $rental->finished_at->format('d.m.y H:i')]) }}
                </span>
            @endif
        </div>
    </div>

    <b>@lang('reservation.item-list')</b>

    <div class="d-flex justify-content-between">
        <p class="ps-2 pe-2">{{ $rental->itemStackNamesString() }}</p>

        @if($rental->isOpen() && $type === 'reservation')
            <div>
                <button type="button" class="btn btn-danger"
                        data-bs-toggle="modal"
                        onclick="document.getElementById('deleteForm').action = '{{ route('reservation.cancel', ['reservation' => $rental]) }}'"
                        data-bs-target="#deleteModal"><i
                        class="bi bi-calendar-minus me-1"></i> @lang('reservation.retract')
                </button>
            </div>
        @endif
    </div>
</div>
