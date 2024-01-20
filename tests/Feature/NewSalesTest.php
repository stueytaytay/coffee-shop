<?php

namespace Tests\Feature;

use Livewire\Livewire;
use Tests\TestCase;
use App\Livewire\Sales\NewSales;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
        Livewire::test(NewSales::class)
            ->set('quantity', 10)
            ->set('unit_cost', 5.0)
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
}
