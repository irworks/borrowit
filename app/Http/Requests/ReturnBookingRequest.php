<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReturnBookingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'itemIds.*' => ['required', 'exists:items,id']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
