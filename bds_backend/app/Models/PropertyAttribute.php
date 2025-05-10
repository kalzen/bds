<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyAttribute extends Model
{
    protected $table = 'property_attributes';

    public $incrementing = false;
    protected $primaryKey = null;

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
