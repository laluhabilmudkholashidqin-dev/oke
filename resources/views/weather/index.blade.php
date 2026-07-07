@extends('layouts.app')

@section('title', 'Weather Dashboard')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <!-- Search Box -->
        <form method="POST" action="{{ route('weather.search') }}" class="search-box">
            @csrf
            <input 
                type="text" 
                name="city" 
                placeholder="Cari kota atau lokasi..." 
                value="{{ $lastSearchedCity ?? '' }}"
                required
            >
            <button type="submit">
                <i class="bi bi-search"></i> Cari
            </button>
            <button type="button" class="btn btn-secondary" onclick="getLocationWeather()">
                <i class="bi bi-geo-alt"></i> Lokasi Saya
            </button>
        </form>

        <!-- Error Message -->
        @if ($error)
            <div class="alert alert-warning" role="alert">
                <i class="bi bi-exclamation-triangle"></i> {{ $error }}
            </div>
        @endif

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
                            <div class="detail-label">Visibilitas</div>
                            <div class="detail-value">{{ round($currentWeather['visibility'] / 1000) }} km</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Suhu Min/Max</div>
                            <div class="detail-value">{{ round($currentWeather['main']['temp_min']) }}°/{{ round($currentWeather['main']['temp_max']) }}°</div>
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
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Sidebar Favorites -->
    @auth
        <div class="col-lg-4">
            @if ($favorites->count() > 0)
                <div class="weather-card">
                    <h3 class="section-title"><i class="bi bi-heart"></i> Lokasi Favorit</h3>
                    <div class="favorites-list">
                        @foreach ($favorites as $favorite)
                            <div class="favorite-item">
                                <form method="POST" action="{{ route('favorites.destroy', $favorite->id) }}" 
                                      onsubmit="return confirm('Hapus favorit ini?')" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-remove" style="float: right;">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                <a href="{{ route('weather.show', $favorite->city) }}">
                                    <i class="bi bi-geo-alt"></i> {{ $favorite->city }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    @endauth
</div>

@endsection

@section('scripts')
<script>
    function getLocationWeather() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                // Send to server
                fetch('{{ route("weather.coordinates") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        latitude: latitude,
                        longitude: longitude
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload page with new location
                        window.location.reload();
                    }
                })
                .catch(error => console.error('Error:', error));
            }, function() {
                alert('Tidak dapat mengakses lokasi Anda. Pastikan izin lokasi sudah diaktifkan.');
            });
        } else {
            alert('Browser Anda tidak mendukung geolocation.');
        }
    }
</script>
@endsection
