<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

class CoffeeSalesTableSeeder extends Seeder
{
    private $profitMargin = 0.25;
    private $shippingCost = 10.00;

    /**
     * Run the database seeds.
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 50; $i++) {
            $quantity = $faker->numberBetween(1, 100);
            $unitCost = $faker->randomFloat(2, 0.5, 10.0);

            // Convert unit cost to pence and calculate cost
            $unitCostPence = $unitCost * 100;
            $cost = $unitCostPence * $quantity;

            // Calculate selling price
            $profitFactor = 1 - $this->profitMargin;
            $sellingPricePence = ($cost / $profitFactor) + ($this->shippingCost * 100);

            // Convert selling price back to pounds and format to two decimal places
            $sellingPrice = number_format($sellingPricePence / 100, 2, '.', '');

            DB::table('coffee_sales')->insert([
                'quantity' => $quantity,
                'unit_cost' => $unitCost,
                'selling_price' => $sellingPrice,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
