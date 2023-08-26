<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReservationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'from' => ['required', 'date_format:Y-m-d\TH:i'],
            'to' => ['required', 'date_format:Y-m-d\TH:i'],
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }
}
