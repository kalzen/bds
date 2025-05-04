<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = ['name', 'data_type'];

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_attributes')
            ->withPivot('value')
            ->withTimestamps();
    }

}
