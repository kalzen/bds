<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class News extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $fillable = ['title','slug', 'description', 'content', 'user_id', 'category_id','publish_date'];
    protected $appends = ['icon_url'];

    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }

    public function userid()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Accessor để lấy URL của icon
    public function getIconUrlAttribute (): ?string
    {
        return $this->getFirstMediaUrl('icon');
    }
}
