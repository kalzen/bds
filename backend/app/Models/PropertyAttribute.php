<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PropertyAttribute extends Pivot
{
    protected $table = 'property_attributes';
    public $timestamps = false;
    protected $fillable = ['property_id', 'attribute_id', 'value'];
}
