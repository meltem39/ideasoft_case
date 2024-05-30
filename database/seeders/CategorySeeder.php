<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => '1. Kategori Adı',
            ],
            [
                'name' => '2. Kategori Adı',
            ]
        ];

        foreach ($categories as $category) {
            Category::insert($category);
        }
    }
}
