<?php

namespace App\Http\Livewire\Pos;
/*
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
    */

    use Livewire\Component;
    use App\Services\BarcodeService;
    
    class BarcodeScanner extends Component
    {
        public $barcode = '';
        protected $barcodeService;
    
        public function boot(BarcodeService $barcodeService)
        {
            $this->barcodeService = $barcodeService;
        }
    
        public function updatedBarcode($value)
        {
            if (!empty($value) && $this->barcodeService->validateEAN13($value)) {
                $this->emit('barcodeScanned', $value);
                $this->barcode = '';
            }
        }
    
        public function render()
        {
            return view('livewire.pos.barcode-scanner');
        }
    }