<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    protected $fillable = ['name', 'description'];

    public function news()
    {
        return $this->hasMany(News::class);
    }
}
