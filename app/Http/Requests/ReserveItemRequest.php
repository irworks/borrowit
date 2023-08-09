<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReserveItemRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'quantity' => ['numeric', 'min:1'],
            'item_stack_id' => ['numeric', 'exists:item_stacks,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
