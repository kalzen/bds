<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceHistory extends Model
{
    protected $table = 'price_history';
    protected $fillable = ['property_id', 'price', 'changed_at'];
    public $timestamps = false;
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
