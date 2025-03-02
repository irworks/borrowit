<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

trait HasFilters
{
    protected function addLikeFilter($query, array $filters, string $field)
    {
        return $query->when($filters[$field] ?? null && !\Str::contains($filters[$field], '%'), function (Builder $query, $value) use ($field) {
            $query->where($field, 'LIKE', "%{$value}%");
        });
    }
}
