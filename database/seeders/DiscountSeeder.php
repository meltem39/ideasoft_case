<?php

namespace Database\Seeders;

use App\Models\Discount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $discounts = [
            [
                "title" => "10_PERCENTAGE_OVER_1000",
                "condition" => "1000",
                "comparison" => ">=",
                "conclusion" => "10",
                "function_name" => "saleTotalProduct",
            ],
            [
                "title" => "20_PERCANTAGE_OVER_BY_2",
                "category_id" => 1,
                "condition" => "2",
                "comparison" => ">=",
                "conclusion" => "20",
                "function_name" => "saleProduct",
            ],
            [
                "title" => "BUY_5_GET_1",
                "category_id" => 2,
                "condition" => "5",
                "comparison" => ">=",
                "conclusion" => "1",
                "function_name" => "freeProduct",
            ],
        ];

        foreach ($discounts as $discount) {
            Discount::insert($discount);
        }
    }
}
