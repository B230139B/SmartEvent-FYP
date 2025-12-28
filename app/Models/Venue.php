<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * (Optional, Laravel auto-detects this)
     */
    protected $table = 'venues';

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'name',
        'location',
        'capacity',
        'price',
        'description',
        'image',
    ];

    /**
     * Cast attributes to correct data types
     * (Prevents subtle bugs)
     */
    protected $casts = [
        'capacity' => 'integer',
        'price' => 'decimal:2',
    ];

    /**
     * Accessor: Get full image URL
     * Usage: $venue->image_url
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        // Default fallback image
        return asset('images/default-venue.jpg');
    }
}
