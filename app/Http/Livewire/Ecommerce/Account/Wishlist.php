<?php

namespace App\Http\Livewire\Ecommerce\Account;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;

class Wishlist extends Component
{
    use WithPagination;

    public $perPage = 12;

    public function removeFromWishlist($productId)
    {
        auth()->user()->wishlist()->detach($productId);
    }

    public function loadMore()
    {
        $this->perPage += 8;
    }

    public function render()
    {
        $products = auth()->user()->wishlist()
            ->with('media')
            ->paginate($this->perPage);

        return view('livewire.ecommerce.account.wishlist', [
            'products' => $products
        ])->layout('layouts.ecommerce', [
            'title' => 'Lista de Deseos',
            'headerStyle' => 'bg-white shadow-sm'
        ]);
    }
}