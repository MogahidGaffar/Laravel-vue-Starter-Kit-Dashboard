<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,   HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'created_at',
        'is_active',
        'avatar',
        'updated_at'
    ];

    protected $appends = ['avatar'];

    public function getAvatarAttribute()
    {
        return asset("storage/{$this->attributes['avatar']}");
    }
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
        'created_at'  => 'date:Y-m-d',
    ];


    
    public function getFormattedCreatedAtAttribute(): string
{
    return $this->created_at->format('d M Y');
}

public function logs(): HasMany
{
    return $this->hasMany(
        \App\Models\Log::class,
        'by_user_id'
    );
}

}
