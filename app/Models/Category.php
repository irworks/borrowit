<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_organisation_required',
    ];

    public function itemStacks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ItemStack::class);
    }

    public function topItemStacks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->itemStacks()->limit(5);
    }
}
