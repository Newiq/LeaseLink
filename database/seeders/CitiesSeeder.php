<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\User;
use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder
{
    public function run(): void
    {
        //lanlord example
        $landlord = User::firstOrCreate(
            ['email' => 'landlord@example.com'],
            [
                'name' => 'Test Landlord',
                'password' => bcrypt('password'),
                'role' => 'landlord'
            ]
        );

        
        $cities = [
            'Montreal' => [
                'min_price' => 1500,
                'max_price' => 3000,
                'image_prefix' => 'montreal'
            ],
            'Ottawa' => [
                'min_price' => 1600,
                'max_price' => 2800,
                'image_prefix' => 'ottawa'
            ],
            'Toronto' => [
                'min_price' => 2000,
                'max_price' => 4000,
                'image_prefix' => 'toronto'
            ],
            'Vancouver' => [
                'min_price' => 2200,
                'max_price' => 4500,
                'image_prefix' => 'vancouver'
            ]
        ];

        foreach ($cities as $city => $details) {
            $count = rand(3, 5);
            for ($i = 1; $i <= $count; $i++) {
                $property = Property::create([
                    'user_id' => $landlord->id,
                    'title' => "$city Apartment #$i",
                    'description' => "Beautiful apartment in $city with modern amenities",
                    'city' => $city,
                    'address' => "123 Main St #$i",
                    'price' => rand($details['min_price'], $details['max_price']),
                    'bedrooms' => rand(1, 3),
                    'bathrooms' => rand(1, 2),
                    'sqft' => rand(500, 2000),
                    'is_available' => true
                ]);

                $imageCount = rand(3, 5);
                for ($j = 1; $j <= $imageCount; $j++) {
                    PropertyImage::create([
                        'property_id' => $property->id,
                        'image_url' => "images/properties/" . strtolower($city) . "/property{$property->id}_$j.jpg",
                        'is_primary' => $j === 1,
                        'display_order' => $j
                    ]);
                }
            }
        }
    }
} 