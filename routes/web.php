<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;

// 加载 auth.php 中的路由
require __DIR__.'/auth.php';

Route::get('/', [HomeController::class, 'index']);

// 公共路由
Route::get('/properties/{city}', [PropertyController::class, 'city'])->name('properties.city');
Route::get('/properties/detail/{property}', [PropertyController::class, 'show'])->name('properties.show');
Route::get('/home', [HomeController::class, 'index'])->name('home');

// 需要认证的路由
Route::middleware(['auth'])->group(function () {
    Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
    
    // 收藏相关路由
    Route::post('/favorites/{property}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::delete('/favorites/{property}', [FavoriteController::class, 'remove'])->name('favorites.remove');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    
    // 租赁相关路由
    Route::get('/rentals', [RentalController::class, 'index'])->name('rentals.index');
    Route::get('/rentals/create', [RentalController::class, 'create'])->name('rentals.create');
    Route::post('/rentals', [RentalController::class, 'store'])->name('rentals.store');
    Route::get('/rentals/{rental}', [RentalController::class, 'show'])->name('rentals.show');
    Route::get('/rentals/{rental}/edit', [RentalController::class, 'edit'])->name('rentals.edit');
    Route::put('/rentals/{rental}', [RentalController::class, 'update'])->name('rentals.update');
    Route::delete('/rentals/{rental}', [RentalController::class, 'destroy'])->name('rentals.destroy');
    Route::delete('/rentals/{rental}/images/{image}', [RentalController::class, 'deleteImage'])->name('rentals.deleteImage');
});
