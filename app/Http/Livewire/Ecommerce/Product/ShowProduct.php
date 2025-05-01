<?php

namespace App\Http\Livewire\Ecommerce\Product;

use Livewire\Component;
use App\Models\Product;
use Cart;

class ShowProduct extends Component
{
    public $product;
    public $selectedVariant = null;
    public $quantity = 1;
    public $activeTab = 'description';
    public $selectedImage;

    public function mount(Product $product)
    {
        $this->product = $product->load('media', 'variants', 'categories', 'reviews.user');
        
        if ($this->product->variants->isNotEmpty()) {
            $this->selectedVariant = $this->product->variants->first()->id;
        }
        
        $this->selectedImage = $this->product->getFirstMediaUrl('default', 'large');
    }

    public function selectVariant($variantId)
    {
        $this->selectedVariant = $variantId;
    }

    public function selectImage($imageUrl)
    {
        $this->selectedImage = $imageUrl;
    }

    public function addToCart()
    {
        $item = [
            'id' => $this->selectedVariant ? 'variant_'.$this->selectedVariant : 'product_'.$this->product->id,
            'name' => $this->product->name,
            'price' => $this->product->price,
            'quantity' => $this->quantity,
            'associatedModel' => $this->product
        ];

        Cart::add($item);
        $this->emit('cartUpdated');
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => 'Producto añadido al carrito'
        ]);
    }

    public function render()
    {
        return view('livewire.ecommerce.product.show-product')
            ->layout('layouts.ecommerce', [
                'title' => $this->product->name,
                'description' => $this->product->meta_description ?? Str::limit($this->product->description, 160),
                'canonical' => route('ecommerce.product.show', $this->product->slug),
                'image' => $this->product->getFirstMediaUrl('default', 'large')
            ]);
    }
}