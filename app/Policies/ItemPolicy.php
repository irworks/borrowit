<?php

namespace App\Policies;

use App\Models\Item;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->role >= UserRole::Manager;
    }

    public function view(User $user, Item $item): bool
    {
        return $user->role >= UserRole::Manager;
    }

    public function create(User $user): bool
    {
        return $user->role >= UserRole::Admin;
    }

    public function update(User $user, Item $item): bool
    {
        return $user->role >= UserRole::Admin;
    }

    public function delete(User $user, Item $item): bool
    {
        return $user->role >= UserRole::Admin;
    }

    public function restore(User $user, Item $item): bool
    {
        return $user->role >= UserRole::Admin;
    }

    public function forceDelete(User $user, Item $item): bool
    {
        return $user->role >= UserRole::Admin;
    }
}
