<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot() //: void
    {
        //
        Livewire::component('pos.barcode-scanner', \App\Http\Livewire\Pos\BarcodeScanner::class);
        
        Livewire::component('pos.pos-interface', \App\Http\Livewire\Pos\PosInterface::class); 

        Livewire::component('pos.customer-search', \App\Http\Livewire\Pos\CustomerSearch::class); 

        Livewire::component('inventory-alert', \App\Http\Livewire\InventoryAlert::class);
        Livewire::component('user-security', \App\Http\Livewire\UserSecurity::class);
    }
}
