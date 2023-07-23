<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'description' => ['nullable'],
            'is_organisation_required' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
