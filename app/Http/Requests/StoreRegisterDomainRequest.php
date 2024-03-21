<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegisterDomainRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'domain' => ['required', 'string', 'unique:register_domains,domain'],
            'active' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
