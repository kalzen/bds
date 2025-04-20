<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = ['name', 'city_id'];
    public $timestamps = false;
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function wards()
    {
        return $this->hasMany(Ward::class);
    }
}

