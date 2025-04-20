<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['ward_id', 'address', 'latitude', 'longitude'];
    public $timestamps = false;
    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
