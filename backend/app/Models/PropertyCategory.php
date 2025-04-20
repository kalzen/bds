<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyCategory extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;
    public function properties()
    {
        return $this->hasMany(Property::class, 'category_id');
    }
}
