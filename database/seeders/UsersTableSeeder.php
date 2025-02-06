<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Test Tenant',
            'email' => 'tenant1@hotmail.com',
            'password' => Hash::make('12345678@Hqw'),
            'role' => 'tenant'
        ]);
    }
} 