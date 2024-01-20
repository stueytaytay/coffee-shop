<?php

namespace App\Livewire\Sales;

use Livewire\Component;
use App\Models\CoffeeSale;

class PreviousSales extends Component
{
    public $coffeeSales;

    protected $listeners = [
        'saleRecorded' => 'refreshSales'
    ];

    public function mount()
    {
        $this->coffeeSales = CoffeeSale::orderBy('created_at', 'desc')->get();
    }

    public function refreshSales()
    {
        $this->coffeeSales = CoffeeSale::orderBy('created_at', 'desc')->get();
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
