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
        Livewire::component('pos.pos-header', \App\Http\Livewire\Pos\PosHeader::class); 
        Livewire::component('pos.notification-handler', \App\Http\Livewire\Pos\NotificationHandler ::class); 

        //Ecommerce
        Livewire::component('ecommerce.layouts.main-layout', \App\Http\Livewire\Ecommerce\Layouts\MainLayout::class);
        Livewire::component('ecommerce.layouts.header', \App\Http\Livewire\Ecommerce\Layouts\Header::class);
        Livewire::component('ecommerce.layouts.footer', \App\Http\Livewire\Ecommerce\Layouts\Footer::class);
        Livewire::component('ecommerce.auth.login', \App\Http\Livewire\Ecommerce\Auth\Login::class);
        Livewire::component('ecommerce.auth.register', \App\Http\Livewire\Ecommerce\Auth\Register::class);
        Livewire::component('ecommerce.account.dashboard', \App\Http\Livewire\Ecommerce\Account\Dashboard::class);
        Livewire::component('ecommerce.account.orders', \App\Http\Livewire\Ecommerce\Account\Orders::class);
        Livewire::component('ecommerce.account.whishlist', \App\Http\Livewire\Ecommerce\Account\Whishlist::class);
        Livewire::component('ecommerce.account.addresses', \App\Http\Livewire\Ecommerce\Account\Addresses::class);
        Livewire::component('ecommerce.shop.product-card', \App\Http\Livewire\Ecommerce\Shop\ProductCard::class);
        Livewire::component('ecommerce.shop.shop-page', \App\Http\Livewire\Ecommerce\Shop\ShopPage::class);
        Livewire::component('ecommerce.cart.mini-cart', \App\Http\Livewire\Ecommerce\Cart\MiniCart::class);
        Livewire::component('ecommerce.cart.cart-page', \App\Http\Livewire\Ecommerce\Cart\CartPage::class);
        Livewire::component('ecommerce.home.featured-products', \App\Http\Livewire\Ecommerce\Home\FeaturedProducts::class);
        Livewire::component('ecommerce.home.home-page', \App\Http\Livewire\Ecommerce\Home\HomePage::class);
        Livewire::component('ecommerce.home.hero-slider', \App\Http\Livewire\Ecommerce\Home\HeroSlider::class);
        Livewire::component('ecommerce.product.show-product', \App\Http\Livewire\Ecommerce\Product\ShowProduct::class);
        Livewire::component('ecommerce.checkout.checkout-wizard', \App\Http\Livewire\Ecommerce\CheckOut\CheckoutWizard::class);
        Livewire::component('ecommerce.checkout.success', \App\Http\Livewire\Ecommerce\CheckOut\Succes::class);
    }
}
