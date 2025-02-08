<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $city = $request->query('city');
        
        if ($city) {

            $properties = Property::with('primaryImage')
                                ->where('city', $city)
                                ->where('is_available', true)
                                ->get();
            return view('properties.city', compact('properties', 'city'));
        }


        $cities = Property::select('city')
            ->distinct()
            ->get()
            ->map(function ($property) {
                $count = Property::where('city', $property->city)
                                ->where('is_available', true)
                                ->count();
                $avgPrice = Property::where('city', $property->city)
                                  ->where('is_available', true)
                                  ->avg('price');
                return [
                    'city' => $property->city,
                    'province' => $this->getProvince($property->city),
                    'propertyCount' => $count,
                    'averagePrice' => round($avgPrice),
                    'imageUrl' => "images/cities/" . strtolower($property->city) . ".jpg"
                ];
            });

        return view('properties.index', compact('cities'));
    }

    private function getProvince($city)
    {
        return [
            'Montreal' => 'QC',
            'Ottawa' => 'ON',
            'Toronto' => 'ON',
            'Vancouver' => 'BC'
        ][$city] ?? '';
    }

    public function city($city)
    {
        $properties = Property::where('city', $city)
            ->where('is_available', true)
            ->with('images')
            ->get();

        return view('properties.city', [
            'city' => $city,
            'properties' => $properties
        ]);
    }

    public function show(Property $property)
    {
        return view('properties.show', compact('property'));
    }
} 