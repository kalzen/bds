<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'name',
        'project_id',
        'category_id',
        'price',
        'area',
        'address',
        'description',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function category()
    {
        return $this->belongsTo(PropertyCategory::class);
    }

    public function amenities()
    {
        return $this->hasMany(PropertyAmenity::class);
    }

    public function attributes()
    {
        return $this->hasMany(PropertyAttribute::class);
    }
}

