<?php

namespace App\Livewire\Settings;

use App\Models\ShippingPartner;
use Livewire\Component;

class ShippingPartners extends Component
{
    public $shippingPartners = [];

    public $successMessage = '';

    public $changesMade = false;

    public function mount()
    {
        $this->shippingPartners = ShippingPartner::all()->toArray();
    }

    public function addShippingPartner()
    {
        $this->shippingPartners[] = ['partner_name' => '', 'shipping_cost' => ''];

        $this->successMessage = '';

        $this->changesMade = true;
    }

    public function saveShippingPartners()
    {
        // Build validation rules - make sure partner names are unique
        $rules = [];
        foreach ($this->shippingPartners as $index => $partner) {
            $uniqueRule = isset($partner['id'])
                ? "unique:shipping_partners,partner_name,{$partner['id']}"
                : 'unique:shipping_partners,partner_name';

            $rules["shippingPartners.$index.partner_name"] = "required|string|min:1|$uniqueRule";
            $rules["shippingPartners.$index.shipping_cost"] = 'required|numeric|min:0.01';
        }

        $this->validate($rules);

        foreach ($this->shippingPartners as $partner) {
            if (isset($partner['id'])) {
                // Update existing shipping partner
                ShippingPartner::find($partner['id'])->update($partner);
            } else {
                // Create new shipping partner
                ShippingPartner::create($partner);
            }
        }

        $this->successMessage = 'Shipping partners saved successfully!';

        $this->changesMade = false;
    }

    public function deleteShippingPartner($index)
    {
        $this->successMessage = '';

        // Find and delete the shipping partner
        $shippingPartnerId = $this->shippingPartners[$index]['id'] ?? null;
        if ($shippingPartnerId) {
            ShippingPartner::find($shippingPartnerId)->delete();
        }

        // Remove it from the array
        unset($this->shippingPartners[$index]);
        $this->shippingPartners = array_values($this->shippingPartners);
    }

    public function updated()
    {
        $this->changesMade = true;
    }

    public function render()
    {
        return view('livewire.settings.shipping-partners');
    }
}
