<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\CoffeeType;

class CoffeeTypes extends Component
{
    public $coffeeTypes = [];
    public $successMessage = '';

    public function mount()
    {
        // Load CoffeeTypes, but convert profit_margin to percentage for display
        $this->coffeeTypes = CoffeeType::all()->map(function ($type) {
            $type->profit_margin *= 100;
            return $type;
        })->toArray();
    }

    public function addCoffeeType()
    {
        $this->coffeeTypes[] = ['coffee_name' => '', 'profit_margin' => ''];

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
        }

        $this->validate($rules);

        foreach ($this->coffeeTypes as $index => $type) {
            $this->coffeeTypes[$index]['profit_margin'] /= 100;
        }

        foreach ($this->coffeeTypes as $type) {
            if (isset($type['id'])) {
                // Update existing coffee type
                CoffeeType::find($type['id'])->update($type);
            } else {
                // Create new coffee type
                CoffeeType::create($type);
            }
        }

        // Convert back to percentage after save otherwise it changes to decimal
        foreach ($this->coffeeTypes as $index => $type) {
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
