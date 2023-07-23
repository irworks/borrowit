<?php

namespace App\Policies;

use App\Models\Organisation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganisationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        
    }

    public function view(User $user, Organisation $organisation): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Organisation $organisation): bool
    {
    }

    public function delete(User $user, Organisation $organisation): bool
    {
    }

    public function restore(User $user, Organisation $organisation): bool
    {
    }

    public function forceDelete(User $user, Organisation $organisation): bool
    {
    }
}
