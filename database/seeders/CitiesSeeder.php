<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CitiesSeeder extends Seeder
{
    public function run(): void
    {
        // 创建示例用户
        $user = User::firstOrCreate(
            ['email' => 'demo@example.com'],
            [
                'name' => 'Demo User',
                'password' => Hash::make('password'),
                'role' => 'user'
            ]
        );

        $cities = [
            'Montreal' => [
                'min_price' => 1000,
                'max_price' => 3000
            ],
            'Ottawa' => [
                'min_price' => 1200,
                'max_price' => 3500
            ],
            'Toronto' => [
                'min_price' => 1500,
                'max_price' => 4000
            ],
            'Vancouver' => [
                'min_price' => 1800,
                'max_price' => 4500
            ]
        ];

        foreach ($cities as $city => $details) {
            $count = rand(3, 5);
            for ($i = 1; $i <= $count; $i++) {
                $property = Property::create([
                    'user_id' => $user->id,  // 使用创建的用户ID
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

                // 创建默认图片记录
                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_url' => 'images/properties/default_property.jpg',
                    'is_primary' => true,
                    'display_order' => 1
                ]);
            }
        }
    }
} 