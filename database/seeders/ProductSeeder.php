<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $category = Category::create([
            'name' => 'Electrónicos',
            'slug' => 'electronicos',
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'Smartphone X',
            'description' => 'Último modelo con 128GB',
            'sku' => 'SMX-128',
            'barcode' => '123456789012',
            'price' => 599.99,
            'cost_price' => 450.00,
            'stock_quantity' => 50,
            'category_id' => $category->id,
        ]);
    }
}