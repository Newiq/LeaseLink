<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Property;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Get cities for the filter
        $cities = City::all();
        
        // Get the selected city from request or set default to null
        $selectedCity = $request->query('city');
        
        // Query properties with optional city filter
        $properties = Property::when($selectedCity, function($query) use ($selectedCity) {
            return $query->where('city_id', $selectedCity);
        })->latest()->get();

        return view('home', compact('cities', 'properties', 'selectedCity'));
    }
} 