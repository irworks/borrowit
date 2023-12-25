<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function create(User $user): bool
    {
        return $user->role >= UserRole::Admin->value;
    }

    public function update(User $user, Category $category): bool
    {
        return $user->role >= UserRole::Admin->value;
    }

    public function delete(User $user, Category $category): bool
    {
        return $user->role >= UserRole::Admin->value;
    }

    public function restore(User $user, Category $category): bool
    {
        return $user->role >= UserRole::Admin->value;
    }

    public function forceDelete(User $user, Category $category): bool
    {
        return $user->role >= UserRole::Admin->value;
    }
}
