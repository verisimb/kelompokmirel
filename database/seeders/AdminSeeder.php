<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Default
        if (!User::where('email', 'admin@spk.com')->exists()) {
            User::create([
                'name' => 'Admin SPK',
                'email' => 'admin@spk.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]);
        }

        // User Default
        if (!User::where('email', 'user@spk.com')->exists()) {
            User::create([
                'name' => 'User SPK',
                'email' => 'user@spk.com',
                'password' => Hash::make('user123'),
                'role' => 'user',
            ]);
        }
    }
}