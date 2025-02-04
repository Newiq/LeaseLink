<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        // 使用静态数据模拟房产列表
        $properties = [
            [
                'id' => 1,
                'title' => 'Modern Apartment',
                'price' => 2000,
                'beds' => 2,
                'baths' => 2,
                'sqft' => 1000,
                'images' => ['properties/default.jpg'],
                'city' => 'Toronto',
                'province' => 'ON'
            ],
            [
                'id' => 2,
                'title' => 'Cozy Studio',
                'price' => 1500,
                'beds' => 1,
                'baths' => 1,
                'sqft' => 500,
                'images' => ['properties/default.jpg'],
                'city' => 'Vancouver',
                'province' => 'BC'
            ],
        ];

        return view('properties.index', compact('properties'));
    }
} 