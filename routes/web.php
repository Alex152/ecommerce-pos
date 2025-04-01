<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ReportController;


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