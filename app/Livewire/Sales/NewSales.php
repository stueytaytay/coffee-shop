<?php

namespace App\Livewire\Sales;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Akaunting\Money\Money;
use App\Models\CoffeeSale;
use App\Models\CoffeeType;

class NewSales extends Component
{
    public $profitMargin = 0.25;
    public $shippingCost = 10.00;
    public $cost;
    public $selling_price;
    public $formattedSellingPrice = '-';
    public $selectedCoffeeType = null;
    public $coffeeTypes = [];

    #[Validate('required|integer|min:1')]
    public $quantity = '';
 
    #[Validate('required|numeric|min:0.01')]
    public $unit_cost = '';

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        if (!$this->getErrorBag()->has($propertyName)) {
            $this->calculateSellingPrice();
        }
    }

    public function calculateSellingPrice()
    {
        if (is_numeric($this->quantity) && is_numeric($this->unit_cost)) {
            // Convert unit cost to the smallest unit (pence)
            $unitCostPence = $this->unit_cost * 100;

            // Calculate cost in pence
            $cost = Money::GBP($unitCostPence)->multiply($this->quantity);

            // Calculate selling price
            $profitFactor = 1 - $this->profitMargin;
            $selling_price = $cost->divide($profitFactor)->add(Money::GBP($this->shippingCost * 100));

            // Format the selling price for display (includes currency symbol)
            $this->formattedSellingPrice = $selling_price->format();

            // Format the selling price for storage
            $this->selling_price = $selling_price->formatSimple();
        }
    }

    public function recordSale()
    {
        $this->validate();

        // Record the sale
        CoffeeSale::create($this->all());

        // Refresh the previous sales table
        $this->dispatch('saleRecorded');

        // Set formattedSellingPrice back to its default display value
        $this->formattedSellingPrice = '-';

        // Reset the form values
        $this->reset();
    }


    public function render()
    {
        return view('livewire.sales.new-sales');
    }
}
