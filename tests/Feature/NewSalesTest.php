<?php

namespace Tests\Feature;

use App\Livewire\Sales\NewSales;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class NewSalesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function new_sales_component_renders_correctly()
    {
        Livewire::test(NewSales::class)
            ->assertStatus(200); // Check if the component renders
    }

    /** @test */
    public function new_sales_form_submission_with_valid_data()
    {
        // Create a shipping partner
        $shippingPartner = \App\Models\ShippingPartner::factory()->create();

        // Create a coffee type associated with the shipping partner
        $coffeeType = \App\Models\CoffeeType::factory()->create([
            'shipping_partner_id' => $shippingPartner->id,
        ]);

        Livewire::test(NewSales::class)
            ->set('quantity', 10)
            ->set('unit_cost', 5.0)
            ->set('selectedCoffeeType', $coffeeType->id)
            ->call('recordSale')
            ->assertHasNoErrors(); // Test form submission with valid data
    }

    /** @test */
    public function new_sales_form_submission_with_invalid_data_shows_errors()
    {
        Livewire::test(NewSales::class)
            ->set('quantity', -1) // Invalid quantity
            ->call('recordSale')
            ->assertHasErrors(['quantity']); // Expect validation error for quantity
    }

    /** @test */
    public function test_handling_non_existing_coffee_type()
    {
        Livewire::test(NewSales::class)
            ->set('selectedCoffeeType', 999)
            ->call('recordSale')
            ->assertHasErrors(['selectedCoffeeType']);
    }

    public function test_profit_margin_calculation()
    {
        // Create a ShippingPartner
        $shippingCost = 10.00;
        $shippingPartner = \App\Models\ShippingPartner::factory()->create([
            'shipping_cost' => $shippingCost,
        ]);

        // Create a CoffeeType with a specific profit margin for predictable results
        $profitMargin = 0.25;
        $coffeeType = \App\Models\CoffeeType::factory()->create([
            'profit_margin' => $profitMargin,
            'shipping_partner_id' => $shippingPartner->id,
        ]);

        $quantity = 1;
        $unitCost = 10.00;

        // Calculate the expected selling price
        $expectedSellingPrice = $this->calculateExpectedSellingPrice($quantity, $unitCost, $profitMargin, $shippingPartner->shipping_cost);

        Livewire::test(NewSales::class)
            ->set('quantity', $quantity)
            ->set('unit_cost', $unitCost)
            ->set('selectedCoffeeType', $coffeeType->id)
            ->call('calculateSellingPrice')
            ->assertSee((string) $expectedSellingPrice);
    }

    // Helper method to calculate the expected selling price
    private function calculateExpectedSellingPrice($quantity, $unitCost, $profitMargin, $shippingCost)
    {
        // Convert unit cost to the smallest unit (pence)
        $unitCostPence = $unitCost * 100;

        // Calculate cost in pence
        $costPence = $unitCostPence * $quantity;

        // Calculate selling price
        $profitFactor = 1 - $profitMargin;
        $sellingPricePence = ($costPence / $profitFactor) + ($shippingCost * 100);

        // Convert pence back to pounds and round to 2 decimal places
        return round($sellingPricePence / 100, 2);
    }
}
