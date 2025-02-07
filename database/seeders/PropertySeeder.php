<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    public function run()
    {
        $landlords = User::where('role', 'landlord')->get();
        
        if ($landlords->isEmpty()) {
            $this->command->warn('No landlords found. Skipping property seeding.');
            return;
        }

        $cities = ['Montreal', 'Ottawa', 'Toronto', 'Vancouver'];
        
        foreach ($cities as $city) {
            for ($i = 0; $i < 5; $i++) {
                Property::create([
                    'title' => "Test Property in {$city} #{$i}",
                    'description' => "A nice property in {$city}",
                    'price' => rand(50000, 150000),
                    'city' => $city,
                    'address' => $this->getRandomAddress($city),
                    'bedrooms' => rand(1, 4),
                    'bathrooms' => rand(1, 3),
                    'square_feet' => rand(500, 2000),
                    'property_type' => $this->getRandomPropertyType(),
                    'year_built' => rand(1990, 2023),
                    'is_available' => true,
                    'user_id' => $landlords->random()->id,
                ]);
            }
        }
    }
    private function getRandomAddress($city)
    {
        $districts = [
            'Montreal' => ['Downtown', 'Plateau', 'Mile End', 'Westmount', 'Old Montreal'],
            'Ottawa' => ['Centretown', 'ByWard Market', 'Glebe', 'Westboro', 'Sandy Hill'],
            'Toronto' => ['Downtown', 'Yorkville', 'The Annex', 'Liberty Village', 'Leslieville'],
            'Vancouver' => ['Downtown', 'Kitsilano', 'Gastown', 'Yaletown', 'West End'],
        ];
        
        $district = $districts[$city][array_rand($districts[$city])];
        $streetNumber = rand(1, 999);
        
        return "{$streetNumber} {$district}, {$city}";
    }


    private function getRandomPropertyType()
    {
        $types = ['Apartment', 'House', 'Condo', 'Studio'];
        return $types[array_rand($types)];
    }
} 