<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ListingType extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $fillable = ['name', 'description'];
    protected $appends = ['icon_url'];

    public function getIconUrlAttribute (): ?string
    {
        $media = $this->getFirstMedia('icon');
        return $media ? url($media->getUrl()) : null;
    }

}
