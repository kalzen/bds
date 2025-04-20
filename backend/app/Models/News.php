<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'content', 'author_id', 'category_id', 'publish_date'];
    public $timestamps = false;
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }
}
