<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Spatie\MediaLibrary\HasMedia;

use Illuminate\Support\Str;

class ImageService
{
    public static function handleProductImageUpload(
        TemporaryUploadedFile $file, 
        ?HasMedia $model = null,
        string $collection = 'main_image',
        bool $isGallery = false
    ): string {
        $filename = self::generateFilename($file);
        
        if ($model) {
            $media = $model->addMedia($file->getRealPath())
                ->usingName(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                ->usingFileName($filename)
                ->toMediaCollection($collection, 'media');
                
            return $media->getUrl();
        }
        
        return $file->storeAs(
            $isGallery ? 'products/temp/gallery' : 'products/temp',
            $filename,
            'media'                 //Antes public
        );
    }

    protected static function generateFilename(TemporaryUploadedFile $file): string
    {
        return Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
            . '-' . Str::random(6)
            . '.' . $file->getClientOriginalExtension();
    }
}