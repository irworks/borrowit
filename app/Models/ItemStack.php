<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemStack extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_set',
        'category_id'
    ];

    protected $casts = [
        'is_set' => 'bool'
    ];

    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Item::class);
    }
}
