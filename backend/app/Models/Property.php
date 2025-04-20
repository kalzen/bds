<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Property extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'user_id', 'project_id', 'listing_type_id', 'category_id', 'location_id',
        'title', 'description', 'price', 'attribute_id',
        'legal_status', 'direction', 'furniture', 'created_at', 'updated_at'
    ];
    public $timestamps = false;
    public function user() { return $this->belongsTo(User::class); }
    public function project() { return $this->belongsTo(Project::class); }
    public function listingType() { return $this->belongsTo(ListingType::class); }
    public function category() { return $this->belongsTo(PropertyCategory::class); }
    public function location() { return $this->belongsTo(Location::class); }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'property_attributes')
            ->withPivot('value');
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'property_amenities');
    }

    public function priceHistories()
    {
        return $this->hasMany(PriceHistory::class);
    }
}
