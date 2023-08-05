<?php

namespace App\Services;

use App\Models\Organisation;
use App\Models\User;

class UserService
{
    public function update(User $user, string $phone, ?int $organisationId, ?string $password): void
    {
        if (empty($organisationId) || !Organisation::whereId($organisationId)->exists()) {
            $user->organisation_id = null;
        } else {
            $user->organisation_id = $organisationId;
        }

        $user->phone = $phone;
        if (!empty($password)) {
            $user->password = \Hash::make($password);
        }

        $user->save();
    }
}