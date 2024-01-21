<?php

namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use App\Models\CoffeeType;
use App\Livewire\Settings\CoffeeTypes;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CoffeeTypesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_coffee_types_load_correctly()
    {
        // Seed the database with a coffee type
        CoffeeType::create(['coffee_name' => 'Arabic coffee', 'profit_margin' => 0.25]);

        Livewire::test(CoffeeTypes::class)
            ->assertSet('coffeeTypes.0.coffee_name', 'Arabic coffee')
            ->assertSet('coffeeTypes.0.profit_margin', 25); // Check if profit margin is converted to percentage
    }

    /** @test */
    public function test_add_new_coffee_type()
    {
        Livewire::test(CoffeeTypes::class)
            ->call('addCoffeeType')
            ->assertSet('coffeeTypes.0.coffee_name', '')
            ->assertSet('coffeeTypes.0.profit_margin', '');
    }

    /** @test */
    public function test_coffee_type_validatiion()
    {
        Livewire::test(CoffeeTypes::class)
            ->set('coffeeTypes.0.coffee_name', '')
            ->set('coffeeTypes.0.profit_margin', -1)
            ->call('saveCoffeeTypes')
            ->assertHasErrors(['coffeeTypes.0.coffee_name' => 'required'])
            ->assertHasErrors(['coffeeTypes.0.profit_margin' => 'min']);
    }

    /** @test */
    public function test_coffee_type_deletion()
    {
        $coffeeType = CoffeeType::create(['coffee_name' => 'Latte', 'profit_margin' => 0.25]);

        Livewire::test(CoffeeTypes::class)
            ->call('deleteCoffeeType', 0)
            ->assertDontSee('Latte');
    }

}
