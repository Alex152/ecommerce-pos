<?php
/*
namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    public static function handleProductImageUpload(TemporaryUploadedFile $file, $record = null, $collection = 'main_image', $multiple = false)
{
    $filePath = $file->store('products/temp', 'public');

    if ($record) {
        $record->addMediaFromDisk($filePath, 'public')
            ->toMediaCollection($collection);

        return $record->getFirstMediaPath($collection);
    }

    return Storage::disk('public')->path($filePath);
}


    protected function afterCreate(): void
    {
        $data = $this->form->getState();

        // Verificamos si hay imagen principal
        if (isset($data['main_image']) && $data['main_image']) {
            $this->record
                ->addMedia($data['main_image'])
                ->toMediaCollection('main_image');
        }

        // Verificamos si hay galería
        if (isset($data['gallery']) && is_array($data['gallery'])) {
            foreach ($data['gallery'] as $image) {
                $this->record
                    ->addMedia($image)
                    ->toMediaCollection('gallery');
            }
        }
    }
}
*/


namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function afterCreate(): void
    {
        $data = $this->form->getState();

        // Imagen principal
        if (!empty($data['main_image'])) {
            $this->record
                ->addMedia(storage_path('app/public/' . $data['main_image']))
                ->toMediaCollection('main_image');
        }

        // Galería
        if (!empty($data['gallery']) && is_array($data['gallery'])) {
            foreach ($data['gallery'] as $imagePath) {
                $this->record
                    ->addMedia(storage_path('app/public/' . $imagePath))
                    ->toMediaCollection('gallery');
            }
        }
    }
}
