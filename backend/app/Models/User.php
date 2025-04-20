<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['full_name', 'email', 'phone', 'password_hash', 'role'];
    public $timestamps = false;
    public function news()
    {
        return $this->hasMany(News::class, 'author_id');
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
