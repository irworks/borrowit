<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReservationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->role >= UserRole::Manager->value;
    }

    public function view(User $user, Reservation $reservation): bool
    {
        return $user->role >= UserRole::Manager->value || $reservation->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function collect(User $user, Reservation $reservation): bool
    {
        return $user->role >= UserRole::Manager->value;
    }


    public function update(User $user, Reservation $reservation): bool
    {
        return $user->role >= UserRole::Manager->value || $reservation->user_id === $user->id;
    }

    public function delete(User $user, Reservation $reservation): bool
    {
        return $user->role >= UserRole::Manager->value;
    }

    public function restore(User $user, Reservation $reservation): bool
    {
        return $user->role >= UserRole::Admin->value;
    }

    public function forceDelete(User $user, Reservation $reservation): bool
    {
        return $user->role >= UserRole::Admin->value;
    }
}
