<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['nullable'],
            'notes' => ['nullable'],
            'item_stack_id' => ['required', 'integer'],
            'is_intact' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
