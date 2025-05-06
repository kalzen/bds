<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'investor',
        'location_id',
        'total_area',
        'number_of_units',
        'description',
        'start_date',
        'end_date',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }


    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}

