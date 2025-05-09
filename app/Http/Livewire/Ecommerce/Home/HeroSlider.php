<?php

namespace App\Http\Livewire\Ecommerce\Home;

use Livewire\Component;
use App\Models\Promotion;

class HeroSlider extends Component
{
    public $currentSlide = 0;
    public $slides = [];
    public $autoPlay = true;
    public $autoPlayInterval = 5000; // 5 segundos
    public $transitionDuration = 700; // 0.7 segundos
    public $isHovered = false;

    public function mount()
    {
        // Obtener las promociones/slides desde la base de datos
        $this->slides = Promotion::active()
            ->where('type', 'hero_slider')
            ->orderBy('priority', 'asc')  // Antes desc para decendente
            ->take(5)
            ->get()
            ->toArray();

        // Si no hay slides en la BD, usar algunos por defecto
        if (empty($this->slides)) {
            $this->slides = [
                [
                    'id' => 1,
                    'title' => 'Colección de Verano',
                    'subtitle' => 'Hasta 40% de descuento',
                    'description' => 'Descubre nuestra nueva colección de verano con los mejores estilos',
                    'image_url' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
                    'button_text' => 'Comprar ahora',
                    'button_url' => '#',
                    'text_color' => 'text-white',
                    'overlay_color' => 'bg-black bg-opacity-40',
                    'text_position' => 'left'
                ],
                [
                    'id' => 2,
                    'title' => 'Nuevos Productos',
                    'subtitle' => 'Lanzamientos exclusivos',
                    'description' => 'Los productos más innovadores ya están disponibles en nuestra tienda',
                    'image_url' => 'https://images.unsplash.com/photo-1555529669-e69e7aa0ba9a?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
                    'button_text' => 'Ver productos',
                    'button_url' => '#',
                    'text_color' => 'text-gray-900',
                    'overlay_color' => 'bg-white bg-opacity-30',
                    'text_position' => 'center'
                ],
                [
                    'id' => 3,
                    'title' => 'Oferta Flash',
                    'subtitle' => 'Solo por 48 horas',
                    'description' => 'Aprovecha estos increíbles descuentos en productos seleccionados',
                    //'image_url' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
                    'image_url' => 'https://images.unsplash.com/photo-1667369039699-f30c4b863e51?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                    'button_text' => 'Aprovechar oferta',
                    'button_url' => '#',
                    'text_color' => 'text-white',
                    'overlay_color' => 'bg-indigo-900 bg-opacity-50',
                    'text_position' => 'right'
                ]
            ];
        }
    }

    public function nextSlide()
    {
        $this->currentSlide = ($this->currentSlide + 1) % count($this->slides);
        $this->resetAutoPlay();
    }

    public function prevSlide()
    {
        $this->currentSlide = ($this->currentSlide - 1 + count($this->slides)) % count($this->slides);
        $this->resetAutoPlay();
    }

    public function goToSlide($index)
    {
        $this->currentSlide = $index;
        $this->resetAutoPlay();
    }

    public function resetAutoPlay()
    {
        if ($this->autoPlay) {
            $this->emit('resetSliderTimer');
        }
    }

    public function toggleAutoPlay()
    {
        $this->autoPlay = !$this->autoPlay;
    }

    public function render()
    {
        return view('livewire.ecommerce.home.hero-slider');
    }
}