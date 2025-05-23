<?php

namespace App\Models;

use App\Services\ActivityLogger;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'firstname',
        'middlename',
        'lastname',
        'username',
        'email',
        'password',
        'roleType',
        'status',
        'birthdate',
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
        'password' => 'hashed',
        'birthdate' => 'date'
    ];
    public function programs(): HasMany
    {
        return $this->hasMany(Program::class, 'user_id');
    }
    protected static function booted()
    {
        static::created(function ($user) {
            ActivityLogger::log("Created user: {$user->username}", $user);
        });

        static::updated(function ($user) {
            ActivityLogger::log("Updated user: {$user->username}", $user);
        });

        static::deleted(function ($user) {
            ActivityLogger::log("Deleted user: {$user->username}", $user);
        });
    }
}
