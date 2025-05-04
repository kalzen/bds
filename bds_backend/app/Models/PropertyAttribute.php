<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyAttribute extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'property_id',
        'attribute_id',
        'value',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
