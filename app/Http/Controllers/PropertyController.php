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
            // 显示特定城市的房产
            $properties = Property::with('primaryImage')
                                ->where('city', $city)
                                ->where('is_available', true)
                                ->get();
            return view('properties.city', compact('properties', 'city'));
        }

        // 显示所有城市卡片
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

    public function show(Property $property)
    {
        return view('properties.show', compact('property'));
    }
} 