<?php

namespace App\Http\Livewire\Ecommerce\Layouts;

use Livewire\Component;
use App\Models\Category;

class MainLayout extends Component
{
    public $categories;
    public $cartItemsCount = 0;

    protected $listeners = ['cartUpdated' => 'updateCartCount'];

    public function mount()
    {
        $this->categories = Category::with('children')->whereNull('parent_id')->get();
        $this->updateCartCount();
    }

    public function updateCartCount()
    {
        $this->cartItemsCount = \Cart::getContent()->count();
    }

    public function render()
    {
        return view('livewire.ecommerce.layouts.main-layout');
    }
}