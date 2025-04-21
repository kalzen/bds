<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyAmenity extends Model
{
    protected $fillable = [
        'property_id',
        'amenity_name',
        'description',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}

