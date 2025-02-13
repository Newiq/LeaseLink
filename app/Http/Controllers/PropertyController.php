<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $city = $request->query('city');
        
        if ($search) {
            $properties = Property::with('images')
                ->where('is_available', true)
                ->where('title', 'like', '%' . $search . '%')
                ->latest()
                ->get();
                
            return view('properties.search', compact('properties', 'search'));
        }
        
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
                
                // 添加城市描述
                $descriptions = [
                    'Montreal' => 'A vibrant city with rich culture and history',
                    'Ottawa' => 'Canada\'s beautiful capital city',
                    'Toronto' => 'A diverse metropolitan hub',
                    'Vancouver' => 'A coastal city surrounded by nature'
                ];

                return [
                    'city' => $property->city,
                    'province' => $this->getProvince($property->city),
                    'propertyCount' => $count,
                    'averagePrice' => round($avgPrice),
                    'description' => $descriptions[$property->city] ?? 'Explore properties in this city',
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
        try {
            $properties = Property::where('city', $city)
                ->where('is_available', true)
                ->with(['images' => function($query) {
                    $query->orderBy('is_primary', 'desc')
                          ->orderBy('display_order', 'asc');
                }])
                ->get();

            // 确保每个属性都有 images 集合
            $properties->each(function ($property) {
                if (!$property->images) {
                    $property->images = collect();
                }
            });

            return view('properties.city', [
                'city' => $city,
                'properties' => $properties
            ]);
        } catch (\Exception $e) {
            Log::error('Error in PropertyController@city: ' . $e->getMessage());
            return back()->with('error', 'Unable to load properties for this city.');
        }
    }

    public function show(Property $property)
    {
        // 预加载关系
        $property->load(['images', 'owner']);
        
        return view('properties.show', compact('property'));
    }
} 