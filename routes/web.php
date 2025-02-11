<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\RentalController;

use Illuminate\Support\Facades\Route;

// 加载 auth.php 中的路由
require __DIR__.'/auth.php';

Route::get('/', [HomeController::class, 'index']);
Route::get('/properties', function () {
    $cities = [
        [
            'city' => 'Montreal',
            'image' => 'https://picsum.photos/800/600?random=1',
            'description' => 'Experience the charm of Montreal'
        ],
        [
            'city' => 'Ottawa',
            'image' => 'https://picsum.photos/800/600?random=2',
            'description' => 'Discover Canada\'s capital'
        ],
        [
            'city' => 'Toronto',
            'image' => 'https://picsum.photos/800/600?random=3',
            'description' => 'Explore the vibrant city of Toronto'
        ],
        [
            'city' => 'Vancouver',
            'image' => 'https://picsum.photos/800/600?random=4',
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

Route::middleware(['auth'])->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{property}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::delete('/favorites/{property}', [FavoriteController::class, 'remove'])->name('favorites.remove');
    Route::get('/rentals/{rental}/edit', [RentalController::class, 'edit'])->name('rentals.edit');
    Route::put('/rentals/{rental}', [RentalController::class, 'update'])->name('rentals.update');
    Route::delete('/rentals/{rental}', [RentalController::class, 'destroy'])->name('rentals.destroy');
    Route::delete('/rentals/{rental}/images/{image}', [RentalController::class, 'deleteImage'])->name('rentals.deleteImage');
});
