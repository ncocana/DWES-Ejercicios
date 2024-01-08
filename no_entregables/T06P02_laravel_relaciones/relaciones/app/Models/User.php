<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'language',
        // RELATION REQUIRED: "USER BELONGSTO PROFILE - PROFILE HASONE USER"
        // 'profile_id',
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
    ];

    // RELATION REQUIRED: "USER BELONGSTO PROFILE - PROFILE HASONE USER"
    // public function BelongsToOneProfile(): BelongsTo {
    //     // return $this->BelongsTo(Profile::class, "profile_id", "id");
    //     return $this->BelongsTo(Profile::class);
    // }

    // RELATION REQUIRED: "USER HASONE PROFILE - PROFILE BELONGSTO USER"
    public function HasOneProfile(): HasOne {
        // return $this->BelongsTo(Profile::class, "profile_id", "id");
        return $this->HasOne(Profile::class);
    }
}
