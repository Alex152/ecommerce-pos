<?php

// app/Http/Livewire/Ecommerce/Product/ImageGallery.php

namespace App\Http\Livewire\Ecommerce\Product;

use Livewire\Component;
use App\Models\Product;

class ImageGallery extends Component
{
    public Product $product;
    public $activeImageIndex = 0;
    public $zoomEnabled = false;
    public $zoomPosition = ['x' => 0, 'y' => 0];
    public $zoomScale = 2;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function setActiveImage($index)
    {
        $this->activeImageIndex = $index;
        $this->zoomEnabled = false;
    }

    public function toggleZoom()
    {
        $this->zoomEnabled = !$this->zoomEnabled;
    }

    public function updateZoomPosition($event)
    {
        if (!$this->zoomEnabled) return;
        
        $container = $event['container'];
        $image = $event['image'];
        
        $x = $event['x'] / $container['width'] * 100;
        $y = $event['y'] / $container['height'] * 100;
        
        $this->zoomPosition = [
            'x' => min(100, max(0, $x)),
            'y' => min(100, max(0, $y))
        ];
    }

    public function getGalleryImagesProperty()
    {
        $images = [];
        
        // Añadir imagen principal primero si existe
        if ($this->product->getFirstMediaUrl('main_image')) {
            $images[] = [
                'url' => $this->product->getFirstMediaUrl('main_image'),
                'thumb' => $this->product->getFirstMediaUrl('main_image', 'thumb'),
                'alt' => $this->product->name
            ];
        }
        
        // Añadir imágenes de la galería
        foreach ($this->product->getMedia('gallery') as $media) {
            $images[] = [
                'url' => $media->getUrl(),
                'thumb' => $media->getUrl('thumb'),
                'alt' => $this->product->name
            ];
        }
        
        // Si no hay imágenes, usar una por defecto
        if (empty($images)) {
            $images[] = [
                'url' => asset('images/default-product.jpg'),
                'thumb' => asset('images/default-product.jpg'),
                'alt' => 'Imagen no disponible'
            ];
        }
        
        return $images;
    }

    public function render()
    {
        return view('livewire.ecommerce.product.image-gallery');
    }
}