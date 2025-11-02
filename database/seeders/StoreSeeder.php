<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sellers = User::where('role', 'seller')->get();

        foreach ($sellers as $seller) {
            Store::create([
                'user_id' => $seller->id,
                'store_name' => 'Toko '.$seller->name,
                'description' => 'Ini adalah deskripsi toko '.$seller->name,
            ]);
        }
    }
}
