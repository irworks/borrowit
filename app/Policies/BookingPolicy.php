<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->role >= UserRole::Manager->value;
    }

    public function view(User $user, Booking $booking): bool
    {
        return $user->role >= UserRole::Manager->value || $booking->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function return(User $user, Booking $booking): bool
    {
        return $user->role >= UserRole::Manager->value;
    }


    public function update(User $user, Booking $booking): bool
    {
        return $user->role >= UserRole::Manager->value || $booking->user_id === $user->id;
    }

    public function delete(User $user, Booking $booking): bool
    {
        return $user->role >= UserRole::Manager->value;
    }

    public function restore(User $user, Booking $booking): bool
    {
        return $user->role >= UserRole::Admin->value;
    }

    public function forceDelete(User $user, Booking $booking): bool
    {
        return $user->role >= UserRole::Admin->value;
    }
}
