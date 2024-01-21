<?php

namespace App\Livewire\Sales;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Akaunting\Money\Money;
use App\Models\CoffeeSale;
use App\Models\CoffeeType;

class NewSales extends Component
{
    public $profitMargin;
    public $shippingCost;
    public $cost;
    public $selling_price;
    public $formattedSellingPrice = '-';
    public $coffeeTypes = [];

    #[Validate('required|exists:coffee_types,id')]
    public $selectedCoffeeType = null;

    #[Validate('required|integer|min:1')]
    public $quantity = '';
 
    #[Validate('required|numeric|min:0.01')]
    public $unit_cost = '';

    public function mount()
    {
        $this->coffeeTypes = CoffeeType::all();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        if (!$this->getErrorBag()->has($propertyName)) {
            $this->calculateSellingPrice();
        }
    }

    public function calculateSellingPrice()
    {
        if (is_numeric($this->quantity) && is_numeric($this->unit_cost) && $this->selectedCoffeeType) {
            $coffeeType = CoffeeType::with('shippingPartner')->find($this->selectedCoffeeType);
            if ($coffeeType && $coffeeType->shippingPartner) {
                $this->profitMargin = $coffeeType->profit_margin;

                // Use the shipping cost associated with the selected coffee type
                $this->shippingCost = $coffeeType->shippingPartner->shipping_cost;

                // Convert unit cost to the smallest unit (pence)
                $unitCostPence = $this->unit_cost * 100;

                // Calculate cost in pence
                $cost = Money::GBP($unitCostPence)->multiply($this->quantity);

                // Calculate selling price
                $profitFactor = 1 - $this->profitMargin;
                $selling_price = $cost->divide($profitFactor)->add(Money::GBP($this->shippingCost * 100));

                // Format the selling price for display and storage
                $this->formattedSellingPrice = $selling_price->format();
                $this->selling_price = $selling_price->formatSimple();
            } else {
                // The shipping partner has been deleted, add an error
                $this->addError('selectedCoffeeType', 'The shipping partner for the selected coffee type is not available.');
            }
        }
    }

    public function recordSale()
    {
        $this->validate();

        // Check if the selected coffee type has a valid shipping partner
        $coffeeType = CoffeeType::with('shippingPartner')->find($this->selectedCoffeeType);
        if (!$coffeeType || !$coffeeType->shippingPartner) {
            $this->addError('selectedCoffeeType', 'The shipping partner for the selected coffee type is not available.');
            return; // Prevent further execution
        }

        // Record the sale
        CoffeeSale::create([
            'quantity' => $this->quantity,
            'unit_cost' => $this->unit_cost,
            'selling_price' => $this->selling_price,
            'coffee_type_id' => $this->selectedCoffeeType,
        ]);

        // Refresh the previous sales table
        $this->dispatch('saleRecorded');

        // Set formattedSellingPrice back to its default display value
        $this->formattedSellingPrice = '-';

        // Reset the form values
        $this->reset(['quantity', 'unit_cost', 'selectedCoffeeType', 'profitMargin', 'shippingCost', 'formattedSellingPrice']);
    }


    public function render()
    {
        return view('livewire.sales.new-sales');
    }
}
