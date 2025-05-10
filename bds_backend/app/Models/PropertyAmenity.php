<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyAmenity extends Model
{
    protected $table = 'property_amenities';

    public $incrementing = false;
    protected $primaryKey = null;

    protected $fillable = [
        'property_id',
        'amenity_id',
        'value',
    ];

    public function amenity()
    {
        return $this->belongsTo(Amenity::class, 'amenity_id');
    }
}

