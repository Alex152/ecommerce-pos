<?php

namespace App\Http\Livewire\Ecommerce\Home;

use Livewire\Component;
use App\Models\Product;

class HeroSlider extends Component
{
    public $slides = [
        [
            'title' => 'Nueva Colección',
            'subtitle' => 'Hasta 40% de descuento',
            'image' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?ixlib=rb-4.0.3',
            'button_text' => 'Comprar Ahora',
            'button_link' => '#'
        ],
        [
            'title' => 'Temporada de Verano',
            'subtitle' => 'Los mejores productos para ti',
            'image' => 'https://images.unsplash.com/photo-1544441893-675973e31985?ixlib=rb-4.0.3',
            'button_text' => 'Descubrir',
            'button_link' => '#'
        ]
    ];

    public $currentSlide = 0;

    public function nextSlide()
    {
        $this->currentSlide = ($this->currentSlide + 1) % count($this->slides);
    }

    public function prevSlide()
    {
        $this->currentSlide = ($this->currentSlide - 1 + count($this->slides)) % count($this->slides);
    }

    public function goToSlide($index)
    {
        $this->currentSlide = $index;
    }

    public function render()
    {
        return view('livewire.ecommerce.home.hero-slider');
    }
}