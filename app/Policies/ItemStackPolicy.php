<?php

namespace App\Policies;

use App\Models\ItemStack;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemStackPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->role >= UserRole::User->value;
    }

    public function view(User $user, ItemStack $itemStack): bool
    {
        return $user->role >= UserRole::User->value;
    }

    public function create(User $user): bool
    {
        return $user->role >= UserRole::Admin->value;
    }

    public function update(User $user, ItemStack $itemStack): bool
    {
        return $user->role >= UserRole::Admin->value;
    }

    public function delete(User $user, ItemStack $itemStack): bool
    {
        return $user->role >= UserRole::Admin->value;
    }

    public function restore(User $user, ItemStack $itemStack): bool
    {
        return $user->role >= UserRole::Admin->value;
    }

    public function forceDelete(User $user, ItemStack $itemStack): bool
    {
        return $user->role >= UserRole::Admin->value;
    }
}
