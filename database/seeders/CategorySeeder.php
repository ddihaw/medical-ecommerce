<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Elektronik', 'Fashion Pria', 'Fashion Wanita', 'Buku', 'Olahraga'];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
            ]);
        }
    }
}
