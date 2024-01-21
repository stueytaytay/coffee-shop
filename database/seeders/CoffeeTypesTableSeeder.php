<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoffeeTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker)
    {
        // Fetch coffee type IDs
        $ShippingPartnerIds = DB::table('shipping_partners')->pluck('id')->toArray();

        $coffeeBeans = [
            ['Arabic coffee', 25],
            ['Gold coffee', 15],
            ['Parisian coffee', 25],
            ['Colombian coffee', 30],
            ['Robusta coffee', 35],
        ];

        foreach ($coffeeBeans as $bean) {
            // Randomly select a coffee type ID
            $randomShippingPartnerId = $faker->randomElement($ShippingPartnerIds);

            DB::table('coffee_types')->insert([
                'coffee_name' => $bean[0],
                'profit_margin' => $bean[1] / 100, // Convert percentage to decimal
                'shipping_partner_id' => $randomShippingPartnerId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
