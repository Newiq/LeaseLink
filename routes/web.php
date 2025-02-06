<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/properties', [PropertyController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/rentals', [App\Http\Controllers\RentalController::class, 'index'])->name('rentals.index');
Route::post('/rentals', [App\Http\Controllers\RentalController::class, 'store'])->name('rentals.store');
