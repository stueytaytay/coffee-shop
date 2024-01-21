<?php

namespace Tests\Feature;

use App\Livewire\Sales\PreviousSales;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PreviousSalesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function previous_sales_component_renders_correctly()
    {
        Livewire::test(PreviousSales::class)
            ->assertStatus(200); // Check if the component renders
    }
}
