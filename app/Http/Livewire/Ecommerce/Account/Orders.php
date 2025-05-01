<?php

namespace App\Http\Livewire\Ecommerce\Account;

use Livewire\Component;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $statusFilter = '';

    public function render()
    {
        $orders = auth()->user()->orders()
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.ecommerce.account.orders', [
            'orders' => $orders
        ])->layout('layouts.ecommerce', [
            'title' => 'Mis Pedidos',
            'headerStyle' => 'bg-white shadow-sm'
        ]);
    }

    public function loadMore()
    {
        $this->perPage += 5;
    }
}