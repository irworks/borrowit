<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone' => ['required', 'string'],
            'organisation_id' => ['required', 'numeric'],
            'new-password' => ['nullable', 'string', 'min:8', 'confirmed']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
