<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Property extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'project_id',
        'listing_type_id',
        'category_id',
        'location_id',
        'name',
        'description',
        'price',
    ];

    // === Relationships ===

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function listingType(): BelongsTo
    {
        return $this->belongsTo(ListingType::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(PropertyCategory::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'property_attributes')
            ->withPivot('value')
            ->withTimestamps(); // nếu bảng có timestamps
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'property_amenities')
            ->withPivot('value');
    }

    // === Media ===

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('properties')->singleFile();
    }
}
