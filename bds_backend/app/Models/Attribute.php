<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Attribute extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['name', 'data_type', 'description'];

    // 👇 THÊM DÒNG NÀY
    protected $appends = ['icon_url'];

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_attributes')
            ->withPivot('value')
            ->withTimestamps();
    }


    public function getIconUrlAttribute()
    {
        $media = $this->getFirstMedia('icon');
        return $media ? url($media->getUrl()) : null;
    }
}
