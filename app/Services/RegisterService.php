<?php

namespace App\Services;

use App\Models\RegisterDomain;

class RegisterService
{
    public function allowedDomains()
    {
        return RegisterDomain::whereActive(true);
    }

    /**
     * Checks if a registration with the given email is allowed.
     * @param string $email
     * @return bool
     */
    public function isRegistrationAllowed(string $email): bool
    {
        if (!config('auth.registration.enabled')) {
            return false;
        }

        // no restrictions, go ahead.
        if (!config('auth.registration.restricted')) {
            return true;
        }

        // we need to check the email domain
        $emailData = explode('@', $email);

        // check for valid email
        if (count($emailData) !== 2 || empty($emailData[0])) {
            return false;
        }

        return $this->allowedDomains()->whereDomain($emailData[1])->exists();
    }
}