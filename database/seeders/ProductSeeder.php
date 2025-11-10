<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stores = Store::all();
        $categoryIds = Category::pluck('id');

        if ($stores->isEmpty() || $categoryIds->isEmpty()) {
            $this->command->warn('Tidak dapat menjalankan ProductSeeder.');
            $this->command->warn('Pastikan Anda sudah memiliki data Store dan Category di database.');
            return;
        }

        $numberOfProducts = 50;
        $this->command->info("Membuat {$numberOfProducts} produk...");

        $products = Product::factory($numberOfProducts)->make();

        $products->each(function ($product) use ($stores, $categoryIds) {

            $product->store_id = $stores->random()->id;
            $product->category_id = $categoryIds->random();
            $product->save();

            $product->images()->create([
                'image_path' => 'products/placeholder.jpg',
                'is_primary' => true
            ]);

            $additionalImages = rand(0, 3);
            for ($i = 0; $i < $additionalImages; $i++) {
                $product->images()->create([
                    'image_path' => 'products/placeholder_extra.jpg', 
                    'is_primary' => false
                ]);
            }
        });

        $this->command->info("Berhasil membuat {$numberOfProducts} produk.");
    }
}
