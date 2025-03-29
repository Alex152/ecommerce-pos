<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class FilamentServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Filament::serving(function () {
            Filament::registerViteTheme('resources/css/filament.css');
            
            Filament::registerUserMenuItems([
                'pos' => UserMenuItem::make()
                    ->label('POS System')
                    ->url(route('pos'))
                    ->icon('heroicon-s-shopping-cart'),
                'settings' => UserMenuItem::make()
                    ->label('Security Settings')
                    ->url(route('profile.show'))
                    ->icon('heroicon-s-cog'),
            ]);
        });

        // CSS para códigos de barras
        Filament::registerRenderHook(
            'head.end',
            fn () => Blade::render('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@barcode-bakery/barcode-common@1.0.0/css/barcode.css"/>'),
        );
    }
}