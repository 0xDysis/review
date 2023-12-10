<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail, FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'profile_pic',
        'banner',
        'role', // Add role to fillable attributes if you want to assign it during mass assignment
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Determine if the user is an admin.
     *
     * @return bool
     */
    public function getIsAdminAttribute()
    {
        return $this->role === 'admin';
    }

    /**
     * Determine if the user is a moderator.
     *
     * @return bool
     */
    public function isModerator()
    {
        // Replace 'moderator' with the appropriate value for your application
        return $this->role === 'moderator';
    }

    /**
     * Determine if the user can access the Filament panel.
     *
     * @param  \Filament\Panel  $panel
     * @return bool
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return in_array($this->role, ['admin', 'moderator']);
    }
    
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }
    
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
