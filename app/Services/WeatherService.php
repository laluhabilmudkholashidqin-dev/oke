<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class WeatherService
{
    protected $client;
    protected $apiKey;
    protected $apiUrl;
    protected $cacheMinutes = 10;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = config('services.openweather.key');
        $this->apiUrl = config('services.openweather.url');
    }

    /**
     * Get current weather by city name
     */
    public function getWeatherByCity($city, $unit = 'metric')
    {
        $cacheKey = "weather_{$city}_{$unit}";

        return Cache::remember($cacheKey, $this->cacheMinutes * 60, function () use ($city, $unit) {
            try {
                $response = $this->client->get("{$this->apiUrl}/weather", [
                    'query' => [
                        'q' => $city,
                        'appid' => $this->apiKey,
                        'units' => $unit,
                        'lang' => 'id'
                    ]
                ]);

                return json_decode($response->getBody(), true);
            } catch (\Exception $e) {
                throw new \Exception('Gagal mengambil data cuaca: ' . $e->getMessage());
            }
        });
    }

    /**
     * Get current weather by coordinates
     */
    public function getWeatherByCoordinates($latitude, $longitude, $unit = 'metric')
    {
        $cacheKey = "weather_{$latitude}_{$longitude}_{$unit}";

        return Cache::remember($cacheKey, $this->cacheMinutes * 60, function () use ($latitude, $longitude, $unit) {
            try {
                $response = $this->client->get("{$this->apiUrl}/weather", [
                    'query' => [
                        'lat' => $latitude,
                        'lon' => $longitude,
                        'appid' => $this->apiKey,
                        'units' => $unit,
                        'lang' => 'id'
                    ]
                ]);

                return json_decode($response->getBody(), true);
            } catch (\Exception $e) {
                throw new \Exception('Gagal mengambil data cuaca: ' . $e->getMessage());
            }
        });
    }

    /**
     * Get 5-day forecast
     */
    public function getForecast($city, $unit = 'metric')
    {
        $cacheKey = "forecast_{$city}_{$unit}";

        return Cache::remember($cacheKey, $this->cacheMinutes * 60, function () use ($city, $unit) {
            try {
                $response = $this->client->get("{$this->apiUrl}/forecast", [
                    'query' => [
                        'q' => $city,
                        'appid' => $this->apiKey,
                        'units' => $unit,
                        'lang' => 'id'
                    ]
                ]);

                $data = json_decode($response->getBody(), true);
                return $this->processForecastData($data);
            } catch (\Exception $e) {
                return null;
            }
        });
    }

    /**
     * Process forecast data to get daily data
     */
    protected function processForecastData($data)
    {
        if (!isset($data['list'])) {
            return [];
        }

        $daily = [];
        $processedDates = [];

        foreach ($data['list'] as $item) {
            $date = date('Y-m-d', $item['dt']);

            if (!in_array($date, $processedDates) && count($processedDates) < 5) {
                $processedDates[] = $date;
                $daily[] = [
                    'date' => $date,
                    'datetime' => date('d M Y', $item['dt']),
                    'day' => date('l', $item['dt']),
                    'temp' => round($item['main']['temp']),
                    'temp_min' => round($item['main']['temp_min']),
                    'temp_max' => round($item['main']['temp_max']),
                    'description' => $item['weather'][0]['main'],
                    'description_id' => $item['weather'][0]['description'],
                    'icon' => $item['weather'][0]['icon'],
                    'humidity' => $item['main']['humidity'],
                    'wind_speed' => $item['wind']['speed'],
                    'pressure' => $item['main']['pressure']
                ];
            }
        }

        return array_slice($daily, 0, 5);
    }

    /**
     * Get weather icon URL
     */
    public function getWeatherIconUrl($iconCode)
    {
        return "https://openweathermap.org/img/wn/{$iconCode}@4x.png";
    }

    /**
     * Get weather description in Indonesian
     */
    public function getWeatherDescription($description)
    {
        $descriptions = [
            'clear sky' => 'Langit Cerah',
            'few clouds' => 'Sedikit Awan',
            'scattered clouds' => 'Awan Tersebar',
            'broken clouds' => 'Awan Tebal',
            'shower rain' => 'Hujan Deras',
            'rain' => 'Hujan',
            'thunderstorm' => 'Badai Petir',
            'snow' => 'Salju',
            'mist' => 'Kabut'
        ];

        foreach ($descriptions as $key => $value) {
            if (stripos($description, $key) !== false) {
                return $value;
            }
        }

        return ucfirst($description);
    }
}
