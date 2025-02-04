<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;

class RentalController extends Controller
{
    private $mockData = [
        'favorites' => [
            [
                'id' => 1,
                'title' => 'Luxury Apartment',
                'price' => 2500,
                'location' => 'Downtown',
                'image_url' => 'images/property1.jpg',
                'beds' => 2,
                'baths' => 2,
                'sqft' => 1000
            ],
            [
                'id' => 2,
                'title' => 'Cozy Studio',
                'price' => 1500,
                'location' => 'Midtown',
                'image_url' => 'images/property2.jpg'
            ]
        ],
        'myListings' => [
            [
                'id' => 3,
                'title' => 'Modern Condo',
                'price' => 3000,
                'location' => 'Uptown',
                'image_url' => 'images/property3.jpg'
            ]
        ]
    ];

    public function index()
    {
        return view('rentals.index', [
            'favorites' => collect($this->mockData['favorites']),
            'myListings' => collect($this->mockData['myListings'])
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        // 只返回成功消息，不实际存储数据
        return redirect()->route('rentals.index')
            ->with('success', 'Rental posted successfully!');
    }
}
