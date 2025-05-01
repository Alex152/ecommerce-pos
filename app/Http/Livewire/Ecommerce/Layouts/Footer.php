<?php

namespace App\Http\Livewire\Ecommerce\Layouts;

use Livewire\Component;
use App\Models\Category;

class Footer extends Component
{
    public $categories;
    public $links = [
        'company' => [
            ['name' => 'Nosotros', 'route' => '#'],
            ['name' => 'Blog', 'route' => '#'],
            ['name' => 'Contacto', 'route' => '#'],
            ['name' => 'Carreras', 'route' => '#'],
        ],
        'legal' => [
            ['name' => 'Política de Privacidad', 'route' => '#'],
            ['name' => 'Términos de Servicio', 'route' => '#'],
            ['name' => 'Política de Reembolsos', 'route' => '#'],
        ]
    ];

    public function mount()
    {
        $this->categories = Category::whereNull('parent_id')
            ->with('children')
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.ecommerce.layouts.footer');
    }
}