<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class FilamentServiceProvider extends ServiceProvider
{

    protected static array $resources = [
        \App\Filament\Resources\ProductResource::class,
        \App\Filament\Resources\SaleResource::class,
        \App\Filament\Resources\CustomerResource::class,
        \App\Filament\Resources\OrderResource::class,
        \App\Filament\Resources\CategoryResource::class,
        \App\Filament\Resources\InventoryResource::class,
        \App\Filament\Resources\SystemSettingResource::class,
        \App\Filament\Resources\DiscountResource::class,
        \App\Filament\Resources\TaxResource::class,
        \App\Filament\Resources\ShippingCarrierResource::class,
        \App\Filament\Resources\UserResource::class,
        \App\Filament\Resources\UserResource::class,
        \App\Filament\Resources\ReportResource::class,
        \App\Filament\Resources\RoleResource::class,
        \App\Filament\Resources\PermissionResource::class,
        \App\Filament\Resources\InventoryMovementResource::class,
        \App\Filament\Resources\WarehouseResource::class,
        \App\Filament\Resources\MovementResource::class,
    ];

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