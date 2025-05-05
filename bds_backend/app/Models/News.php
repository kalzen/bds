<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = ['title', 'content', 'description', 'content', 'user_id', 'category_id','publish_date'];

    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }

    public function userid()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
