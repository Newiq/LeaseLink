<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;


require __DIR__.'/auth.php';

Route::get('/', [HomeController::class, 'index']);

Route::get('/properties/{city}', [PropertyController::class, 'city'])->name('properties.city');
Route::get('/properties/detail/{property}', [PropertyController::class, 'show'])->name('properties.show');
Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::middleware(['auth'])->group(function () {
    Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');

    Route::post('/favorites/{property}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::delete('/favorites/{property}', [FavoriteController::class, 'remove'])->name('favorites.remove');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    

    Route::prefix('rentals')->group(function () {
        Route::get('/', [RentalController::class, 'index'])->name('rentals.index');
        Route::get('/create', [RentalController::class, 'create'])->name('rentals.create');
        Route::post('/', [RentalController::class, 'store'])->name('rentals.store');
        
        Route::get('/{rental}', [RentalController::class, 'show'])->name('rentals.show');
        Route::get('/{rental}/edit', [RentalController::class, 'edit'])->name('rentals.edit');
        Route::put('/{rental}', [RentalController::class, 'update'])->name('rentals.update');
        Route::delete('/{rental}', [RentalController::class, 'destroy'])->name('rentals.destroy');
        Route::delete('/{rental}/images/{image}', [RentalController::class, 'deleteImage'])
            ->name('rentals.deleteImage');
    });
});

Route::get('storage/{path}', function($path) {
    return response()->file(storage_path('app/public/' . $path));
})->where('path', '.*');

Route::get('/debug/images', function() {
    $images = \App\Models\PropertyImage::with('property')->get();
    $files = scandir(public_path('images/properties'));
    
    $imageDetails = $images->map(function($image) {
        return [
            'id' => $image->id,
            'url' => $image->image_url,
            'full_path' => public_path($image->image_url),
            'exists' => file_exists(public_path($image->image_url)),
            'public_url' => asset($image->image_url)
        ];
    });
    
    return [
        'database_images' => $imageDetails,
        'physical_files' => $files,
        'directory_exists' => is_dir(public_path('images/properties')),
        'directory_writable' => is_writable(public_path('images/properties')),
        'public_path' => public_path('images/properties')
    ];
});
