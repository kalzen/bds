<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Amenity extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['name', 'description'];

    public function listings()
    {
        return $this->belongsToMany(Listing::class);
    }

    // Accessor để lấy URL của icon
    public function getIconUrlAmenity(): ?string
    {
        return $this->getFirstMediaUrl('icon');
    }
}
