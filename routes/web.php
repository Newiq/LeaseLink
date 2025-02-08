<?php

use App\Http\Controllers\HomeController;

use Illuminate\Support\Facades\Route;

// 加载 auth.php 中的路由
require __DIR__.'/auth.php';

Route::get('/', [HomeController::class, 'index']);
Route::get('/properties', function () {
    $cities = [
        [
            'city' => 'Montreal',
            'image' => 'images/properties/montreal/cover.jpg',
            'description' => 'Experience the charm of Montreal'
        ],
        [
            'city' => 'Ottawa',
            'image' => 'images/properties/ottawa/cover.jpg',
            'description' => 'Discover Canada\'s capital'
        ],
        [
            'city' => 'Toronto',
            'image' => 'images/properties/toronto/cover.jpg',
            'description' => 'Explore the vibrant city of Toronto'
        ],
        [
            'city' => 'Vancouver',
            'image' => 'images/properties/vancouver/cover.jpg',
            'description' => 'Experience the beauty of Vancouver'
        ]
    ];
    
    return view('properties.index', compact('cities'));
})->middleware(['auth'])->name('properties.index');
Route::get('/properties/{city}', [App\Http\Controllers\PropertyController::class, 'city'])->name('properties.city');
Route::get('/properties/detail/{property}', [App\Http\Controllers\PropertyController::class, 'show'])->name('properties.show');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/rentals', [App\Http\Controllers\RentalController::class, 'index'])->name('rentals.index');
Route::get('/rentals/create', [App\Http\Controllers\RentalController::class, 'create'])->name('rentals.create');
Route::post('/rentals', [App\Http\Controllers\RentalController::class, 'store'])->name('rentals.store');
Route::get('/rentals/{rental}', [App\Http\Controllers\RentalController::class, 'show'])->name('rentals.show');
