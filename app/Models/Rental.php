<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $fillable = ['title', 'description', 'price', 'address', 'area', 'layout', 'city_id'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
} 