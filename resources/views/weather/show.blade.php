@extends('layouts.app')

@section('title', $city . ' - Weather Dashboard')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <!-- Back Button -->
        <a href="{{ route('weather.index') }}" class="btn btn-outline-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>

        <!-- Current Weather -->
        @if ($currentWeather)
            <div class="current-weather">
                <div class="weather-info">
                    <h2>{{ $currentWeather['name'] }}, {{ $currentWeather['sys']['country'] ?? 'ID' }}</h2>
                    <img src="https://openweathermap.org/img/wn/{{ $currentWeather['weather'][0]['icon'] }}@4x.png" 
                         alt="Weather" class="weather-icon">
                    <div class="weather-description">
                        {{ ucfirst($currentWeather['weather'][0]['description']) }}
                    </div>
                    <div class="temperature">{{ round($currentWeather['main']['temp']) }}°C</div>
                    
                    <div class="weather-details">
                        <div class="detail-item">
                            <div class="detail-label">Terasa Seperti</div>
                            <div class="detail-value">{{ round($currentWeather['main']['feels_like']) }}°C</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Kelembaban</div>
                            <div class="detail-value">{{ $currentWeather['main']['humidity'] }}%</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Tekanan</div>
                            <div class="detail-value">{{ $currentWeather['main']['pressure'] }} hPa</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Kecepatan Angin</div>
                            <div class="detail-value">{{ round($currentWeather['wind']['speed']) }} m/s</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Arah Angin</div>
                            <div class="detail-value">{{ $currentWeather['wind']['deg'] ?? 'N/A' }}°</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Visibilitas</div>
                            <div class="detail-value">{{ round($currentWeather['visibility'] / 1000) }} km</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add to Favorites -->
            @auth
                <div style="text-align: center; margin-bottom: 30px;">
                    <form method="POST" action="{{ route('favorites.store') }}" style="display: inline;">
                        @csrf
                        <input type="hidden" name="city" value="{{ $currentWeather['name'] }}">
                        <button type="submit" class="btn" style="background: var(--warning-gradient); color: white; border: none;">
                            <i class="bi bi-star"></i> Tambah ke Favorit
                        </button>
                    </form>
                </div>
            @endauth
        @endif

        <!-- Forecast -->
        @if ($forecast && count($forecast) > 0)
            <div class="weather-card">
                <h3 class="section-title"><i class="bi bi-calendar3"></i> Prakiraan 5 Hari</h3>
                <div class="forecast-container">
                    @foreach ($forecast as $day)
                        <div class="forecast-card">
                            <div class="forecast-date">{{ date('d M', strtotime($day['date'])) }}</div>
                            <div class="forecast-day">{{ substr($day['day'], 0, 3) }}</div>
                            <img src="https://openweathermap.org/img/wn/{{ $day['icon'] }}@2x.png" 
                                 alt="Weather" class="forecast-icon">
                            <div class="forecast-temp">{{ $day['temp'] }}°C</div>
                            <small>{{ $day['temp_min'] }}° - {{ $day['temp_max'] }}°</small>
                            <div style="font-size: 0.8rem; margin-top: 8px; opacity: 0.9;">
                                💧 {{ $day['humidity'] }}% | 💨 {{ round($day['wind_speed']) }} m/s
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
