<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Sales Agent',
            'email' => 'sales@coffee.shop',
        ]);

        // Run coffee types seeder before sales to generate IDs
        $this->call(CoffeeTypesTableSeeder::class);

        $this->call(CoffeeSalesTableSeeder::class);
    }
}
