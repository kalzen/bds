<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PropertyCategory extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['name', 'description'];

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function getIconUrlAmenity(): ?string
    {
        return $this->getFirstMediaUrl('icon');
    }
}
