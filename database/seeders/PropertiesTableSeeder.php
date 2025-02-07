<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertiesTableSeeder extends Seeder
{
    public function run()
    {
        // 首先需要确保有用户存在
        $userId = DB::table('users')->insertGetId([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // 然后插入属性数据
        DB::table('properties')->insert([
            [
                'user_id' => $userId,  // 添加 user_id
                'title' => 'Modern Condo in Toronto',
                'description' => 'Modern condo in downtown Toronto',
                'city' => 'Toronto',
                'address' => '123 Queen Street',
                'price' => 750000,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'sqft' => 1200,
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userId,  // 添加 user_id
                'title' => 'Spacious House in Vancouver',
                'description' => 'Spacious house with mountain view',
                'city' => 'Vancouver',
                'address' => '456 West Broadway',
                'price' => 1200000,
                'bedrooms' => 4,
                'bathrooms' => 3,
                'sqft' => 2500,
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userId,
                'title' => 'Charming Apartment in Montreal',
                'description' => 'Charming apartment in historic building',
                'city' => 'Montreal',
                'address' => '789 Rue Saint-Catherine',
                'price' => 550000,
                'bedrooms' => 2,
                'bathrooms' => 1,
                'sqft' => 1000,
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userId,
                'title' => 'Contemporary Townhouse in Calgary',
                'description' => 'Contemporary townhouse near downtown',
                'city' => 'Ottawa',
                'address' => '321 5th Avenue SW',
                'price' => 480000,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'sqft' => 1800,
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
} 