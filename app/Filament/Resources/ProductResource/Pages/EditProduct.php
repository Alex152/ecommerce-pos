<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
{
    $data = $this->form->getState();

    // Imagen principal
    if (!empty($data['main_image']) && is_file(storage_path('app/public/' . $data['main_image']))) {
        $this->record->clearMediaCollection('main_image');
        $this->record
            ->addMedia(storage_path('app/public/' . $data['main_image']))
            ->toMediaCollection('main_image');
    }

    // Galería
    if (!empty($data['gallery']) && is_array($data['gallery'])) {
        $this->record->clearMediaCollection('gallery');
        foreach ($data['gallery'] as $imagePath) {
            if (is_file(storage_path('app/public/' . $imagePath))) {
                $this->record
                    ->addMedia(storage_path('app/public/' . $imagePath))
                    ->toMediaCollection('gallery');
            }
        }
    }
}

}
