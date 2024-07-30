<?php

namespace App\Rules;

use App\Services\RegisterService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidatesEmailDomainRule implements ValidationRule
{
    public function __construct(public RegisterService $registerService)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->registerService->isRegistrationAllowed($value)) {
            $fail("The {$attribute} \"{$value}\" does not belong to a allowed domain.");
            return;
        }
    }
}
