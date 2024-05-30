<?php

namespace Database\Seeders;

use App\Models\Product;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $products = [
            [
                'name' => $faker->text(20),
                'category_id' => 1,
                'price' => $faker->randomFloat(2, 0, 1000),
                'stock' => $faker->numberBetween(1, 10)
            ],
            [
                'name' => $faker->text(20),
                'category_id' => 1,
                'price' => $faker->randomFloat(2, 0, 1000),
                'stock' => $faker->numberBetween(1, 10)
            ],
            [
                'name' => $faker->text(20),
                'category_id' => 2,
                'price' => $faker->randomFloat(2, 0, 1000),
                'stock' => $faker->numberBetween(1, 10)
            ],
            [
                'name' => $faker->text(20),
                'category_id' => 2,
                'price' => $faker->randomFloat(2, 0, 1000),
                'stock' => $faker->numberBetween(1, 10)
            ],
            [
                'name' => $faker->text(20),
                'category_id' => 2,
                'price' => $faker->randomFloat(2, 0, 1000),
                'stock' => $faker->numberBetween(1, 10)
            ],
            [
                'name' => $faker->text(20),
                'category_id' => 2,
                'price' => $faker->randomFloat(2, 0, 1000),
                'stock' => $faker->numberBetween(1, 10)
            ],
            [
                'name' => $faker->text(20),
                'category_id' => 2,
                'price' => $faker->randomFloat(2, 0, 1000),
                'stock' => $faker->numberBetween(1, 10)
            ],
            [
                'name' => $faker->text(20),
                'category_id' => 2,
                'price' => $faker->randomFloat(2, 0, 1000),
                'stock' => $faker->numberBetween(1, 10)
            ],
        ];

        foreach ($products as $product) {
            Product::insert($product);
        }
    }
}
