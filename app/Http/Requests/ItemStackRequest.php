<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemStackRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'image' => ['nullable', 'file', 'image', 'mimes:jpeg,png,jpg,gif'],
            'description' => ['nullable'],
            'is_set' => ['nullable'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
