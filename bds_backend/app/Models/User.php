<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'password',
        'role',
    ];

    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    public $timestamps = true;

    /**
     * Set the user's password hash.
     */
    public function setPassword(string $password): void
    {
        $this->password_hash = Hash::make($password);
    }

    /**
     * Verify the user's password.
     */
    public function verifyPassword(string $password): bool
    {
        return Hash::check($password, $this->password_hash);
    }

    /**
     * Set the user's password.
     */
    public function setPasswordAttribute(string $password): void
    {
        $this->attributes['password_hash'] = Hash::make($password);
    }

    /**
     * Get the user's password.
     */
    public function getPasswordAttribute(): string
    {
        return $this->password_hash;
    }


    /**
     * Check if the user's email is verified.
     */
    public function hasVerifiedEmail(): bool
    {
        return !is_null($this->email_verified_at);
    }

    /**
     * Mark the user's email as verified.
     */
    public function markEmailAsVerified(): void
    {
        $this->email_verified_at = now();
        $this->save();
    }
}
