<?php

namespace App\Http\Livewire\Pos;

use Livewire\Component;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;

class PosHeader extends Component
{
    public $saleId;
    public $saleStatus = 'pending';
    public $userName;

    public function mount()
    {
        $this->userName = Auth::user()->name;
    }

    public function newSale()
    {
        $this->emit('resetCart');
        $this->saleId = null;
        $this->saleStatus = 'pending';
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'New sale started'
        ]);
    }
    /*
    public function showSales()
    {
        $this->dispatch('openModal', ['component' => 'sales.list']);

    }

    public function showCustomers()
    {
        $this->dispatch('openModal', [ 'component' => 'customers.list' ]);
    }*/

    public function showSales()
    {
        return redirect()->route('filament.admin.resources.sales.index');
    }

    public function showCustomers()
    {
        return redirect()->route('filament.admin.resources.customers.index');
    }

    public function render()
    {
        return view('livewire.pos.pos-header');
    }
}