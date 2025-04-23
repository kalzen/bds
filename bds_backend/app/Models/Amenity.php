<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $fillable = ['name', 'description'];
    public $timestamps = false;
    public function listings()
    {
        return $this->belongsToMany(Listing::class);
    }
}
