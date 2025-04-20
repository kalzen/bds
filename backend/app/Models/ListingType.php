<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingType extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;
    public function properties()
    {
        return $this->hasMany(Property::class, 'listing_type_id');
    }
}
