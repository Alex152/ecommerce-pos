<?php

namespace App\Http\Livewire\Ecommerce\Layouts;

use Livewire\Component;
use App\Models\Category;
//use Cart;
use Gloudemans\Shoppingcart\Facades\Cart;

class Header extends Component
{
    public $categories;
    public $cartItemsCount = 0;
//    public $searchQuery = '';

    protected $listeners = ['cartUpdated' => 'updateCartCount'];

    public function mount()
    {
        $this->categories = Category::with('children')->whereNull('parent_id')->get();
        $this->updateCartCount();
    }
/*
    public function updateCartCount()
    {
        $this->cartItemsCount = Cart::getContent()->count();
    }*/

    public function updateCartCount()
    {
        $this->cartItemsCount = Cart::instance('default')->count();
    }
/*
    public function search()
    {
        return redirect()->route('ecommerce.shop', ['search' => $this->searchQuery]);
    }
*/
    public function render()
    {
        return view('livewire.ecommerce.layouts.header');
    }
}