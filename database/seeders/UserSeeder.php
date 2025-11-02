<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('admin@test.com'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Seller',
            'email' => 'seller@test.com',
            'password' => Hash::make('seller@test.com'),
            'role' => 'seller',
        ]);

        User::create([
            'name' => 'Buyer',
            'email' => 'buyer@test.com',
            'password' => Hash::make('buyer@test.com'),
            'role' => 'buyer',
        ]);

        User::factory(5)->create(['role' => 'buyer']);
        User::factory(2)->create(['role' => 'seller']);
    }
}
