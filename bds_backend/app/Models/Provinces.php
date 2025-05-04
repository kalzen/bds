<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinces extends Model
{
    protected $fillable = ['name', 'slug', 'type', 'name_with_type', 'code'];

    public function districts()
    {
        return $this->hasMany(District::class, 'parent_code', 'code');
    }
}

