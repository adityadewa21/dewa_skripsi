<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Accessories' => [
                'Leather Bag',
                'Mini Sling Bag',
                'Gold Necklace',
                'Classic Belt',
                'Silk Scarf',
            ],
            'Sweater' => [
                'Oversize Sweater',
                'Knitted Sweater',
                'Basic Sweatshirt',
                'Hoodie Casual',
                'Crop Sweater',
            ],
            'Jackets' => [
                'Denim Jacket',
                'Leather Jacket',
                'Bomber Jacket',
                'Blazer Jacket',
                'Winter Coat',
            ],
            'Dress' => [
                'Atiyya Dress',
                'Floral Dress',
                'Midi Dress',
                'Evening Dress',
                'Casual Dress',
            ],
        ];

        foreach ($categories as $categoryName => $products) {

            $category = Category::firstOrCreate(
                ['slug' => Str::slug($categoryName)],
                ['name' => $categoryName]
            );

            foreach ($products as $index => $productName) {

                $basePrice = rand(150000, 400000);

                $product = Product::create([
                    'category_id' => $category->id,
                    'name'        => $productName,
                    'slug'        => Str::slug($productName) . '-' . ($index + 1),
                    'description' => $productName . ' berkualitas premium, nyaman dipakai dan stylish.',
                    'base_price'  => $basePrice,
                ]);

                // Variant READY
                ProductVariant::create([
                    'product_id' => $product->id,
                    'color_name' => 'Hitam',
                    'price'      => $basePrice,
                    'stock'      => rand(5, 20),
                    'status'     => 'ready',
                ]);

                // Variant PREORDER
                ProductVariant::create([
                    'product_id'         => $product->id,
                    'color_name'         => 'Cream',
                    'price'              => $basePrice + 20000,
                    'stock'              => 0,
                    'status'             => 'preorder',
                    'po_estimation_days' => rand(5, 10),
                ]);
            }
        }
    }
}
