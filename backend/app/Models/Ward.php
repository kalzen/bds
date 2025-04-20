<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $fillable = ['name', 'district_id'];
    public $timestamps = false;
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }
}
