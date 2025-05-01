<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ReportController;

//Ecommerce
use App\Http\Livewire\Ecommerce\Home\HomePage;
use App\Http\Livewire\Ecommerce\Shop\ShopPage;
use App\Http\Livewire\Ecommerce\Product\ShowProduct;
use App\Http\Livewire\Ecommerce\Cart\CartPage;
use App\Http\Livewire\Ecommerce\Checkout\CheckoutWizard;
use App\Http\Livewire\Ecommerce\Account\Dashboard;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    //Route::get('/dashboard', function () {
    //    return view('dashboard');
    //})->name('dashboard');
});

//Route::middleware(['auth'])->group(function () {
//    Route::get('/pos', \App\Http\Livewire\Pos\PosInterface::class)->name('pos');
//});   




// Ruta del Dashboard
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// POS System
Route::middleware(['auth'])->group(function () {
    Route::get('/pos', \App\Http\Livewire\Pos\PosInterface::class)->name('pos');
});


// Reportes Action con vista blade
//Route::middleware(['auth', 'role:admin'])->group(function () {
//    Route::get('/reports/sales', [ReportController::class, 'salesReport']);
//});

Route::get('/reports/sales', [ReportController::class, 'salesReport'])
     ->name('sales.report');

// API Interna
Route::middleware('auth')->prefix('api')->group(function () {
    Route::get('products/search', fn() => \App\Models\Product::search(request('q'))->get());
});




// Página Principal
Route::get('/', HomePage::class)->name('ecommerce.home');

// Tienda
Route::get('/tienda', ShopPage::class)->name('ecommerce.shop');
Route::get('/categoria/{category:slug}', ShopPage::class)->name('ecommerce.shop.category');
//Route::get('/marca/{brand:slug}', ShopPage::class)->name('ecommerce.shop.brand');

// Producto
Route::get('/producto/{product:slug}', ShowProduct::class)->name('ecommerce.product.show');

// Carrito
Route::get('/carrito', CartPage::class)->name('ecommerce.cart');

// Checkout
Route::get('/checkout', CheckoutWizard::class)->name('ecommerce.checkout');

// Cuenta de Cliente
Route::prefix('cuenta')->group(function () {
    Route::get('/', Dashboard::class)->name('ecommerce.account.dashboard');
    Route::get('/pedidos', \App\Http\Livewire\Ecommerce\Account\Orders::class)->name('ecommerce.account.orders');
    Route::get('/direcciones', \App\Http\Livewire\Ecommerce\Account\Addresses::class)->name('ecommerce.account.addresses');
    Route::get('/lista-de-deseos', \App\Http\Livewire\Ecommerce\Account\Wishlist::class)->name('ecommerce.account.wishlist');
});

// Autenticación
Route::get('/login', \App\Http\Livewire\Ecommerce\Auth\Login::class)->name('ecommerce.login');
Route::get('/registro', \App\Http\Livewire\Ecommerce\Auth\Register::class)->name('ecommerce.register');