<?php

use App\Http\Controllers\HomeController;

use Illuminate\Support\Facades\Route;

// 加载 auth.php 中的路由
require __DIR__.'/auth.php';

Route::get('/', [HomeController::class, 'index']);
Route::get('/properties', [App\Http\Controllers\PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{city}', [App\Http\Controllers\PropertyController::class, 'city'])->name('properties.city');
Route::get('/properties/detail/{property}', [App\Http\Controllers\PropertyController::class, 'show'])->name('properties.show');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/rentals', [App\Http\Controllers\RentalController::class, 'index'])->name('rentals.index');
Route::get('/rentals/create', [App\Http\Controllers\RentalController::class, 'create'])->name('rentals.create');
Route::post('/rentals', [App\Http\Controllers\RentalController::class, 'store'])->name('rentals.store');
Route::get('/rentals/{rental}', [App\Http\Controllers\RentalController::class, 'show'])->name('rentals.show');
