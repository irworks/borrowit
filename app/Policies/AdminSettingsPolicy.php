<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminSettingsPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->role >= UserRole::Admin->value;
    }
}
