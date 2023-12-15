<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'alias',
        'address',
        // RELATION REQUIRED: "USER HASONE PROFILE - PROFILE BELONGSTO USER"
        'user_id',
    ];

    // RELATION REQUIRED: "USER BELONGSTO PROFILE - PROFILE HASONE USER"
    // public function HasOneUser(): HasOne {
    //     return $this->hasOne(User::class);
    // }

    // RELATION REQUIRED: "USER HASONE PROFILE - PROFILE BELONGSTO USER"
    public function BelongsToOneUser(): BelongsTo {
        return $this->BelongsTo(User::class);
    }
}
