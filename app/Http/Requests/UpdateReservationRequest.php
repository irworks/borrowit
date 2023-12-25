<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class UpdateReservationRequest extends FormRequest
{
    public function rules(): array
    {
        \Validator::extend('valid_date_range', function ($attribute, $value, $parameters, $validator) {
            $startDate = Carbon::createFromFormat('Y-m-d\TH:i', $this->request->get($parameters[1]));
            $dateEnd = Carbon::createFromFormat('Y-m-d\TH:i', $value);

            return $startDate->lessThanOrEqualTo($dateEnd);
        });

        return [
            'from' => ['required', 'date_format:Y-m-d\TH:i'],
            'to' => ['required', 'date_format:Y-m-d\TH:i', 'valid_date_range:to,from'],
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }
}
