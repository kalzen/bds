<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyAttribute extends Model
{
    protected $fillable = [
        'property_id',
        'attribute_name',
        'value',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}

