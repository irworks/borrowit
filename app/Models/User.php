<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'password',
        'phone',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function reservations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function hasCurrentReservation(): bool
    {
        return $this->reservations()
            ->whereNull(['submitted_at', 'fulfilled_at'])
            ->exists();
    }

    public function getCreatedAtStringAttribute(): string
    {
        return $this->created_at?->format(config('app.time_format')) ?? '';
    }

    public function getLastLoginAtStringAttribute(): string
    {
        return $this->last_login_at?->format(config('app.time_format')) ?? '-';
    }

    private function addLikeFilter($query, array $filters, string $field)
    {
        return $query->when($filters[$field] ?? null && !\Str::contains($filters[$field], '%'), function (Builder $query, $value) use ($field) {
            $query->where($field, 'LIKE', "%{$value}%");
        });
    }

    public function scopeFilter($query, array $filters)
    {
        $this->addLikeFilter($query, $filters, 'name');
        $this->addLikeFilter($query, $filters, 'email');
        $this->addLikeFilter($query, $filters, 'phone');

        $query->when($filters['role'] ?? null, function (Builder $query, $value) {
            $query->where('role', '=', $value);
        });

        $query->when($filters['active'] ?? null, function (Builder $query, $value) {
            $query->where('active', '=', ($value === 'true'));
        });
    }
}
