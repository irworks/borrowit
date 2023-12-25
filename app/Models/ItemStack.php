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
        'category_id',
        'image_uri'
    ];

    protected $casts = [
        'is_set' => 'bool'
    ];

    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function hasImage(): bool
    {
        return !empty($this->image_uri);
    }

    public function getCreatedAtStringAttribute(): string
    {
        return $this->created_at->format(config('app.time_format'));
    }
}
