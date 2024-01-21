<?php

namespace App\Livewire\Sales;

use App\Models\CoffeeSale;
use Livewire\Component;

class PreviousSales extends Component
{
    public $coffeeSales;

    protected $listeners = [
        'saleRecorded' => 'refreshSales',
    ];

    public function mount()
    {
        $this->coffeeSales = CoffeeSale::with(['coffeeType' => function ($query) {
            $query->withTrashed(); // Include soft-deleted CoffeeTypes
        }, 'coffeeType.shippingPartner' => function ($query) {
            $query->withTrashed(); // Include soft-deleted ShippingPartners
        }])->orderBy('created_at', 'desc')->get();
        
    }

    public function refreshSales()
    {
        $this->coffeeSales = CoffeeSale::with(['coffeeType' => function ($query) {
            $query->withTrashed(); // Include soft-deleted CoffeeTypes
        }, 'coffeeType.shippingPartner' => function ($query) {
            $query->withTrashed(); // Include soft-deleted ShippingPartners
        }])->orderBy('created_at', 'desc')->get();        

        $this->dispatch('refreshComponent');
    }

    public function deleteSale($saleId)
    {
        $sale = CoffeeSale::find($saleId);
        if ($sale) {
            $sale->delete();
            $this->coffeeSales = CoffeeSale::all();
        }
    }

    public function render()
    {
        return view('livewire.sales.previous-sales');
    }
}
