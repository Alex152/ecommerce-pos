<?php

namespace App\Http\Livewire\Ecommerce\Account;

use Livewire\Component;
use App\Models\Order;

class Dashboard extends Component
{
    public $recentOrders;
    public $wishlistCount;

    public function mount()
    {
        $this->recentOrders = auth()->user()->orders()
            ->latest()
            ->take(3)
            ->get();

        $this->wishlistCount = auth()->user()->wishlist()->count();
    }

    public function render()
    {
        return view('livewire.ecommerce.account.dashboard')
            ->layout('layouts.ecommerce', [
                'title' => 'Mi Cuenta',
                'headerStyle' => 'bg-white shadow-sm'
            ]);
    }
}