<?php

namespace App\Livewire\Settings;

use App\Models\CoffeeType;
use App\Models\ShippingPartner;
use Livewire\Component;

class CoffeeTypes extends Component
{
    public $coffeeTypes = [];

    public $shippingPartners = [];

    public $selectedShippingPartner = [];

    public $successMessage = '';

    public function mount()
    {
        // Load CoffeeTypes, but convert profit_margin to percentage for display
        $this->coffeeTypes = CoffeeType::all()->map(function ($type) {
            $type->profit_margin *= 100;

            return $type;
        })->toArray();

        // Load the shipping partners
        $this->shippingPartners = ShippingPartner::all();

        // Get the selected shipping partners
        foreach ($this->coffeeTypes as $index => $type) {
            $this->selectedShippingPartner[$index] = $type['shipping_partner_id'] ?? null;
        }
    }

    public function addCoffeeType()
    {
        $this->coffeeTypes[] = ['coffee_name' => '', 'profit_margin' => '', 'shipping_partner_id' => null];

        $this->successMessage = '';
    }

    public function saveCoffeeTypes()
    {
        // Build validation rules - make sure coffee names are unique
        $rules = [];
        foreach ($this->coffeeTypes as $index => $type) {
            $uniqueRule = isset($type['id'])
                ? "unique:coffee_types,coffee_name,{$type['id']}"
                : 'unique:coffee_types,coffee_name';

            $rules["coffeeTypes.$index.coffee_name"] = "required|string|min:1|$uniqueRule";
            $rules["coffeeTypes.$index.profit_margin"] = 'required|numeric|min:0.01';
            $rules["selectedShippingPartner.$index"] = 'required|exists:shipping_partners,id';
        }

        $this->validate($rules);

        foreach ($this->coffeeTypes as $index => &$type) {
            // Convert profit margin from percentage to decimal
            $this->coffeeTypes[$index]['profit_margin'] /= 100;

            // Assign the selected shipping partner
            $type['shipping_partner_id'] = $this->selectedShippingPartner[$index];

            if (isset($type['id'])) {
                // Update existing coffee type
                CoffeeType::find($type['id'])->update($type);
            } else {
                // Create new coffee type
                CoffeeType::create($type);
            }

            // Convert back to percentage after save otherwise it changes to decimal in the view
            $this->coffeeTypes[$index]['profit_margin'] *= 100;
        }

        $this->successMessage = 'Coffee types saved successfully!';
    }

    public function deleteCoffeeType($index)
    {
        $this->successMessage = '';

        // Find and delete the coffee type
        $coffeeTypeId = $this->coffeeTypes[$index]['id'] ?? null;
        if ($coffeeTypeId) {
            CoffeeType::find($coffeeTypeId)->delete();
        }

        // Remove it from the array
        unset($this->coffeeTypes[$index]);
        $this->coffeeTypes = array_values($this->coffeeTypes);
    }

    public function render()
    {
        return view('livewire.settings.coffee-types');
    }
}
