<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ShippingPartnersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $shippingCompanies = [
            ['Royal Mail', 10],
            ['DHL', 8],
            ['Evri', 11],
            ['FedEx', 5],
        ];

        foreach ($shippingCompanies as $company) {
            DB::table('shipping_partners')->insert([
                'partner_name' => $company[0],
                'shipping_cost' => $company[1],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
