<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:1', 'max:194'],
            'description' => ['nullable', 'string'],
            'is_organisation_required' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
