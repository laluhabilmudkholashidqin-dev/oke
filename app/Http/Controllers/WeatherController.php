<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use App\Models\FavoriteLocation;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function index()
    {
        $currentWeather = null;
        $forecast = null;
        $favorites = auth()->check() ? FavoriteLocation::where('user_id', auth()->id())->get() : collect();
        $error = null;
        $lastSearchedCity = session('last_searched_city');

        try {
            // Default ke Jakarta jika tidak ada search
            if ($lastSearchedCity) {
                $currentWeather = $this->weatherService->getWeatherByCity($lastSearchedCity);
                $forecast = $this->weatherService->getForecast($lastSearchedCity);
            } else {
                $currentWeather = $this->weatherService->getWeatherByCity('Jakarta');
                $forecast = $this->weatherService->getForecast('Jakarta');
            }
        } catch (\Exception $e) {
            $error = 'Gagal mengambil data cuaca: ' . $e->getMessage();
        }

        return view('weather.index', [
            'currentWeather' => $currentWeather,
            'forecast' => $forecast,
            'favorites' => $favorites,
            'error' => $error,
            'lastSearchedCity' => $lastSearchedCity
        ]);
    }

    public function search(Request $request)
    {
        $validated = $request->validate([
            'city' => 'required|string|max:100',
            'unit' => 'nullable|in:metric,imperial'
        ]);

        try {
            $currentWeather = $this->weatherService->getWeatherByCity($validated['city'], $validated['unit'] ?? 'metric');
            $forecast = $this->weatherService->getForecast($validated['city'], $validated['unit'] ?? 'metric');

            session(['last_searched_city' => $validated['city']]);
            session(['temperature_unit' => $validated['unit'] ?? 'metric']);

            return view('weather.show', [
                'currentWeather' => $currentWeather,
                'forecast' => $forecast,
                'city' => $validated['city']
            ]);
        } catch (\Exception $e) {
            return back()->withError('Kota tidak ditemukan: ' . $e->getMessage());
        }
    }

    public function show($city)
    {
        try {
            $unit = session('temperature_unit', 'metric');
            $currentWeather = $this->weatherService->getWeatherByCity($city, $unit);
            $forecast = $this->weatherService->getForecast($city, $unit);

            return view('weather.show', [
                'currentWeather' => $currentWeather,
                'forecast' => $forecast,
                'city' => $city
            ]);
        } catch (\Exception $e) {
            return redirect('/')->withError('Cuaca tidak ditemukan');
        }
    }

    public function getWeatherByCoordinates(Request $request)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        try {
            $weather = $this->weatherService->getWeatherByCoordinates(
                $validated['latitude'],
                $validated['longitude']
            );

            return response()->json([
                'success' => true,
                'data' => $weather
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data cuaca'
            ], 400);
        }
    }
}
