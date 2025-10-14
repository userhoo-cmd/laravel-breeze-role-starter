<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'avatar', // add this
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Allow access to Filament for admin users.
     */
    public function canAccessFilament(): bool
    {
        return $this->hasRole('admin') || $this->is_admin;
    }

    /**
     * Helper: Get user's full name.
     */
    public function getFullname()
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    /**
     * ✅ Fix for missing getAvatar()
     * Returns a default avatar if user image not set.
     */
    public function getAvatar(): string
{
    return $this->avatar 
        ? asset('storage/avatars/' . $this->avatar)
        : asset('images/default-avatar.png');
}

}
