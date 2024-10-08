<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterDomain extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain', 'active'
    ];

    protected $casts = [
        'active' => 'bool'
    ];
}
