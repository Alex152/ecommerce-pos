<?php

namespace App\Services;

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Picqer\Barcode\BarcodeGeneratorPNG;

class BarcodeService
{
    public function generateEAN13(string $code): string
    {
        $generator = new BarcodeGeneratorPNG();
        return 'data:image/png;base64,' . base64_encode(
            $generator->getBarcode($code, $generator::TYPE_EAN_13)
        );
    }

    public function generateQR(string $data): string
    {
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new ImagickImageBackEnd()
        );
        $writer = new Writer($renderer);
        return 'data:image/svg+xml;base64,' . base64_encode(
            $writer->writeString($data)
        );
    }

    public function validateEAN13(string $barcode): bool
    {
        return preg_match('/^\d{13}$/', $barcode);
    }
}