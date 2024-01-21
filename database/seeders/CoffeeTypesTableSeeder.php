<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CoffeeTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coffeeBeans = [
            ['Arabic coffee', 25],
            ['Gold coffee', 15],
            ['Parisian coffee', 25],
            ['Colombian coffee', 30],
            ['Robusta coffee', 35],
        ];

        foreach ($coffeeBeans as $bean) {
            DB::table('coffee_types')->insert([
                'coffee_name' => $bean[0],
                'profit_margin' => $bean[1] / 100, // Convert percentage to decimal
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
