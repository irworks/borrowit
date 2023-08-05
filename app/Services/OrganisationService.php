<?php

namespace App\Services;

use App\Models\Organisation;

class OrganisationService
{
    public function index()
    {
        return Organisation::all();
    }

    public function selectArray(bool $withNone): array
    {
        $data = Organisation::pluck('name', 'id')->toArray();
        if ($withNone) {
            return [0 => __('general.none')] + $data;
        }

        return $data;
    }
}