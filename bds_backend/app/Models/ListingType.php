<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ListingType extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $fillable = ['name'];

    public function getIconUrlListingType(): ?string
    {
        return $this->getFirstMediaUrl('icon');
    }

}
