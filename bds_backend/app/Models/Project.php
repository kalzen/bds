<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'location',
        'description',
        'start_date',
        'end_date',
    ];

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}

