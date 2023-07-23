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
        return $user->role >= UserRole::User;
    }

    public function view(User $user, ItemStack $itemStack): bool
    {
        return $user->role >= UserRole::User;
    }

    public function create(User $user): bool
    {
        return $user->role >= UserRole::Admin;
    }

    public function update(User $user, ItemStack $itemStack): bool
    {
        return $user->role >= UserRole::Admin;
    }

    public function delete(User $user, ItemStack $itemStack): bool
    {
        return $user->role >= UserRole::Admin;
    }

    public function restore(User $user, ItemStack $itemStack): bool
    {
        return $user->role >= UserRole::Admin;
    }

    public function forceDelete(User $user, ItemStack $itemStack): bool
    {
        return $user->role >= UserRole::Admin;
    }
}
