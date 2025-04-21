<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['name', 'district_id', 'latitude', 'longitude'];

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
