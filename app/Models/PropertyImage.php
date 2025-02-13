<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    protected $fillable = [
        'property_id',
        'image_url',
        'is_primary',
        'display_order'
    ];

    protected $casts = [
        'is_primary' => 'boolean'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function user()
    {
        return $this->property->user();
    }

    public function getImageUrlAttribute($value)
    {
        return $value;
    }
} 