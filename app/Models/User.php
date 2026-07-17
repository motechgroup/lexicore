<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the matters linked to the client user.
     */
    public function matters(): HasMany
    {
        return $this->hasMany(Matter::class, 'client_id');
    }

    /**
     * Get the matters assigned to the attorney user.
     */
    public function attorneyMatters(): HasMany
    {
        return $this->hasMany(Matter::class, 'lead_attorney_id');
    }

    /**
     * Get the invoices linked to the client user.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'client_id');
    }

    /**
     * Get the attorney profile record associated with the user.
     */
    public function attorneyProfile(): HasOne
    {
        return $this->hasOne(AttorneyProfile::class, 'user_id');
    }
}
