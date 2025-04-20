<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PropertyAmenity extends Pivot
{
    protected $table = 'property_amenities';

    protected $fillable = ['property_id', 'amenity_id'];
    public $timestamps = false;

    /**
     * @param string $table
     * @param string[] $fillable
     * @param bool $timestamps
     */
    public function __construct(string $table, array $fillable, bool $timestamps)
    {
        $this->table = $table;
        $this->fillable = $fillable;
        $this->timestamps = $timestamps;
    }
}
