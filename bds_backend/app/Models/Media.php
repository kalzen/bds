<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = ['file_path', 'type', 'listing_id'];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
