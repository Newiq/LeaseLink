<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {

        if (!User::where('email', 'test@hotmail.com')->exists()) {
            User::create([
                'name' => 'qiwen',
                'email' => 'test@hotmail.com',  
                'password' => Hash::make('784751939@Hqw'),
                'role' => 'tenant',
            ]
        );
        }
    }
} 