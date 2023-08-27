<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'itemIds.*' => ['numeric', 'exists:items,id']
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }
}
