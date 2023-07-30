<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->role >= UserRole::Admin->value;
    }

    public function view(User $user, User $model): bool
    {
        return $user->role >= UserRole::Manager->value || $model->id === $user->id;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, User $model): bool
    {
        return $user->role >= UserRole::Admin->value || $model->id === $user->id;
    }

    public function delete(User $user, User $model): bool
    {
        return $user->role >= UserRole::Admin->value || $model->id === $user->id;
    }

    public function restore(User $user, User $model): bool
    {
        return $user->role >= UserRole::Admin->value || $model->id === $user->id;
    }

    public function forceDelete(User $user, User $model): bool
    {
        return $user->role >= UserRole::Admin->value || $model->id === $user->id;
    }
}
