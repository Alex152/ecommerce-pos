<?php

namespace App\Http\Livewire\Ecommerce\Product;

use Livewire\Component;
use App\Models\Product;
use Cart;
use Illuminate\Support\Str; // <-- ESTA LÍNEA ES IMPORTANTE

class ShowProduct extends Component
{
    public $product;
    public $selectedVariant = null;
    public $quantity = 1;
    public $activeTab = 'description';
    public $selectedImage;

    
    public function mount(Product $product)
    {
        //$this->product = $product->load('media', 'variants', 'category', 'reviews.customer');
        $this->product = $product->loadCount('reviews')->load('media', 'variants', 'category', 'reviews.customer');


        if ($this->product->variants->isNotEmpty()) {
            $this->selectedVariant = $this->product->variants->first()->id;
        }
        
        //$this->selectedImage = $this->product->getFirstMediaUrl('default', 'large');
        $this->selectedImage = $this->product->getFirstMediaUrl('main_image', 'large')
    ?: $this->product->getFirstMediaUrl('gallery', 'large')
    ?: asset('images/default-product.jpg');

    }

    public function selectVariant($variantId)
    {
        $this->selectedVariant = $variantId;
    }

    public function selectImage($imageUrl)
    {
        $this->selectedImage = $imageUrl;
        $this->dispatch('imageChanged'); // Dispara un evento para Alpine.js
    }

    public function addToCart()
    {
        /*
        $item = [
            'id' => $this->selectedVariant ? 'variant_'.$this->selectedVariant : 'product_'.$this->product->id,
            'name' => $this->product->name,
            'price' => $this->product->price,
            'quantity' => $this->quantity, // ← este campo está mal   se usa qty en este Cart
            'associatedModel' => $this->product // ← esto NO es compatible
        ];
        */

        //Sintaxys correcta:
        $cartItem = Cart::add([
            'id' => $this->selectedVariant ? 'variant_'.$this->selectedVariant : $this->product->id,
            'name' => $this->product->name,
            'price' => $this->product->price,
            'qty' => $this->quantity, // 👈 correcto
            'options' => [
                // Aquí podrías pasar datos del variant, imagen, etc. si hace falta
            ],
        ])->associate(Product::class); // 👈 FUNDAMENTAL para tener `$item->model`

        //Cart::add($item);
        $this->dispatch('cartUpdated');
        $this->dispatch('notify', [
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