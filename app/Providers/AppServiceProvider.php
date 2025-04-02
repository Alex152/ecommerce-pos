<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()//: void
    {
        //
        $this->app->singleton(BarcodeService::class);
        $this->app->singleton(PaymentService::class);
        $this->app->singleton(InventoryService::class);
        $this->app->singleton(TaxService::class);
        $this->app->singleton(ShippingCalculator::class);
        $this->app->singleton(ExportService::class);
        $this->app->singleton(NotificationService::class);
        $this->app->singleton(RateLimiterService::class);
        $this->app->singleton(ReportService::class);
        $this->app->singleton(RolePermissionSyncService::class);
        $this->app->singleton(SessionSecurityService::class);
        $this->app->singleton(TwoFactorAuthService::class);
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
        Livewire::component('pos.stock-management', \App\Http\Livewire\Pos\StockManagement::class);
    }
}
