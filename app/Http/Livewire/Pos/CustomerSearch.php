<?php
// No hay columna DNI
namespace App\Http\Livewire\Pos;

use Livewire\Component;
use App\Models\Customer;

class CustomerSearch extends Component
{
    public $query = '';
    public $customers = [];

    public function updatedQuery()
    {
        $this->customers = Customer::where('name', 'like', "%{$this->query}%")
            ->orWhere('dni', 'like', "%{$this->query}%")
            ->limit(5)
            ->get()
            ->toArray();
    }

    public function selectCustomer($customerId)
    {
        $this->emit('customerSelected', $customerId);
        $this->reset(['query', 'customers']);
    }

    public function render()
    {
        return view('livewire.pos.customer-search');
    }
}