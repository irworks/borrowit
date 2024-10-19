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

    public function intactItems(): \Illuminate\Database\Eloquent\Relations\HasMany|\LaravelIdea\Helper\App\Models\_IH_Item_QB
    {
        return $this->items()->where('is_intact', '=', true);
    }

    public function hasImage(): bool
    {
        return !empty($this->image_uri);
    }

    public function imageSavePath(bool $basePathOnly = false): string
    {
        $basePath = config('app.images.uploads.itemStacks');
        if ($basePathOnly) {
            return "/{$basePath}";
        }

        return public_path( "{$basePath}/");
    }

    public function imageFileName(string $extension): string
    {
        return "{$this->id}-stack.{$extension}";
    }

    public function getCreatedAtStringAttribute(): string
    {
        return $this->created_at->format(config('app.time_format'));
    }
}
