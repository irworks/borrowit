<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DynamicContent extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'slot',
        'content',
        'html',
    ];

    protected function casts(): array
    {
        return [
            'html' => 'boolean',
        ];
    }
}
