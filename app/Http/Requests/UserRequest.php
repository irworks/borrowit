<?php

namespace App\Http\Requests;

use App\Models\UserRole;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'max:254'],
            'phone' => ['required', 'string'],
            'role' => ['nullable', 'integer', 'min:' . UserRole::User->value, 'max:' . UserRole::Admin->value],
            'active' => ['nullable'],
            'organisation_id' => ['nullable', 'integer']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
