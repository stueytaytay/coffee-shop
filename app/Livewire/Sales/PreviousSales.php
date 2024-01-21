<?php

namespace App\Livewire\Sales;

use App\Models\CoffeeSale;
use Livewire\Component;

class PreviousSales extends Component
{
    public $coffeeSales;

    public $perPage = 5;

    public $currentPage = 1;

    protected $listeners = [
        'saleRecorded' => 'refreshSales',
    ];

    public function mount()
    {
        $this->loadSales();
        
    }

    public function loadSales()
    {
        $this->coffeeSales = CoffeeSale::with(['coffeeType' => function ($query) {
                $query->withTrashed();
            }, 'coffeeType.shippingPartner' => function ($query) {
                $query->withTrashed();
            }])
            ->orderBy('created_at', 'desc')
            ->take($this->perPage * $this->currentPage) // Fetch items for the current page
            ->get();
    }

    public function loadMore()
    {
        $this->currentPage++;
        
        $this->loadSales();
    }

    public function refreshSales()
    {
        $this->loadSales(); 

        $this->dispatch('refreshComponent');
    }

    public function deleteSale($saleId)
    {
        $sale = CoffeeSale::find($saleId);
        if ($sale) {
            $sale->delete();
            
            $this->loadSales(); 
        }
    }

    public function render()
    {
        return view('livewire.sales.previous-sales');
    }
}
