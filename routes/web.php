<?php

use App\Http\Controllers\WeatherController;
use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WeatherController::class, 'index'])->name('weather.index');
Route::post('/search', [WeatherController::class, 'search'])->name('weather.search');
Route::get('/weather/{city}', [WeatherController::class, 'show'])->name('weather.show');
Route::post('/coordinates', [WeatherController::class, 'getWeatherByCoordinates'])->name('weather.coordinates');

Route::middleware('auth')->group(function () {
    Route::post('/favorites', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{favorite}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
    Route::get('/api/favorites', [FavoriteController::class, 'getFavorites'])->name('favorites.api');
});
