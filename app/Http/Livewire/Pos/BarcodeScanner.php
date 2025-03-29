<?php

namespace App\Http\Livewire\Pos;

use Livewire\Component;

class BarcodeScanner extends Component
{
    public $barcode = '';

    public function scanBarcode()
    {
        if (!empty($this->barcode)) {
            // Reemplazado emit() por dispatch()
            $this->dispatch('productScanned', barcode: $this->barcode);
            $this->barcode = '';
        }
    }

    public function render()
    {
        return view('livewire.pos.barcode-scanner');
    }
}