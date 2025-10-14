<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $sampleProducts = [
            ['name' => 'Laptop', 'description' => 'High performance laptop', 'price' => 2500.00, 'quantity' => 5, 'status' => 'active'],
            ['name' => 'Mouse', 'description' => 'Wireless mouse', 'price' => 35.50, 'quantity' => 20, 'status' => 'active'],
            ['name' => 'Keyboard', 'description' => 'Mechanical keyboard', 'price' => 89.90, 'quantity' => 10, 'status' => 'active'],
            ['name' => 'Monitor', 'description' => '24 inch LED monitor', 'price' => 499.00, 'quantity' => 8, 'status' => 'active'],
            ['name' => 'USB Drive', 'description' => '32GB USB drive', 'price' => 25.00, 'quantity' => 50, 'status' => 'active'],
            ['name' => 'Headphones', 'description' => 'Noise-cancelling headphones', 'price' => 199.00, 'quantity' => 15, 'status' => 'active'],
            ['name' => 'Webcam', 'description' => 'HD webcam', 'price' => 75.00, 'quantity' => 12, 'status' => 'active'],
            ['name' => 'Printer', 'description' => 'Laser printer', 'price' => 350.00, 'quantity' => 7, 'status' => 'active'],
            ['name' => 'Router', 'description' => 'Wireless router', 'price' => 150.00, 'quantity' => 20, 'status' => 'active'],
            ['name' => 'Tablet', 'description' => '10 inch tablet', 'price' => 900.00, 'quantity' => 5, 'status' => 'active'],
            ['name' => 'Smartphone', 'description' => 'Latest smartphone', 'price' => 1800.00, 'quantity' => 8, 'status' => 'active'],
            ['name' => 'Charger', 'description' => 'Fast charging adapter', 'price' => 45.00, 'quantity' => 30, 'status' => 'active'],
            ['name' => 'Power Bank', 'description' => '10000mAh power bank', 'price' => 120.00, 'quantity' => 25, 'status' => 'active'],
            ['name' => 'SSD', 'description' => '1TB Solid State Drive', 'price' => 350.00, 'quantity' => 10, 'status' => 'active'],
            ['name' => 'External HDD', 'description' => '2TB external hard drive', 'price' => 250.00, 'quantity' => 15, 'status' => 'active'],
        ];

        foreach ($sampleProducts as $index => $product) {
            $product['barcode'] = 'PROD' . str_pad($index + 1, 5, '0', STR_PAD_LEFT); // e.g., PROD00001
            Product::create($product);
        }
    }
}
