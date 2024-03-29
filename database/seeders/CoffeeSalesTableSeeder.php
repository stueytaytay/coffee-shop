<?php

namespace Database\Seeders;

use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoffeeSalesTableSeeder extends Seeder
{
    private $profitMargin = 0.25;

    private $shippingCost = 10.00;

    /**
     * Run the database seeds.
     */
    public function run(Faker $faker)
    {
        // Fetch coffee type IDs
        $coffeeTypeIds = DB::table('coffee_types')->pluck('id')->toArray();

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

            // Randomly select a coffee type ID
            $randomCoffeeTypeId = $faker->randomElement($coffeeTypeIds);

            DB::table('coffee_sales')->insert([
                'quantity' => $quantity,
                'unit_cost' => $unitCost,
                'selling_price' => $sellingPrice,
                'coffee_type_id' => $randomCoffeeTypeId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
