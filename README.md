# Weather Dashboard

Weather Dashboard adalah aplikasi web yang menampilkan informasi cuaca real-time dari berbagai lokasi menggunakan OpenWeatherMap API.

## Fitur Utama

- 🌤️ Tampilkan cuaca lokasi saat ini
- 🔍 Cari cuaca berdasarkan nama kota
- 📍 Geolokasi otomatis
- 📊 Forecast 5 hari
- 🌡️ Informasi detail (suhu, kelembaban, tekanan, angin)
- 🎨 Gradient design modern
- 📱 Responsive layout
- ⭐ Simpan lokasi favorit
- 🌍 Konversi unit (Celsius/Fahrenheit)

## Requirements

- PHP 8.0+
- Laravel 9.x+
- MySQL/MariaDB
- OpenWeatherMap API Key (gratis)

## Instalasi

### 1. Clone Repository
```bash
git clone <repository-url>
cd weather-dashboard
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Dapatkan API Key
- Daftar di https://openweathermap.org/api
- Dapatkan API key gratis
- Tambahkan ke file `.env`:
```
OPENWEATHER_API_KEY=your_api_key_here
OPENWEATHER_API_URL=https://api.openweathermap.org/data/2.5
```

### 5. Setup Database
```bash
php artisan migrate
```

### 6. Jalankan Aplikasi
```bash
php artisan serve
```

Akses aplikasi di `http://localhost:8000`

## Struktur Folder

```
.
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── WeatherController.php
│   │       └── FavoriteController.php
│   ├── Models/
│   │   └── FavoriteLocation.php
│   └── Services/
│       └── WeatherService.php
├── database/
│   └── migrations/
│       └── create_favorite_locations_table.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── weather/
│       │   ├── index.blade.php
│       │   └── show.blade.php
│       └── components/
│           ├── weather-card.blade.php
│           └── forecast-card.blade.php
├── routes/
│   └── web.php
└── .env.example
```

## API Endpoints

- `GET /` - Dashboard cuaca
- `POST /search` - Cari cuaca berdasarkan kota
- `POST /favorites` - Tambah lokasi favorit
- `GET /favorites` - Lihat lokasi favorit
- `DELETE /favorites/{id}` - Hapus lokasi favorit

## Teknologi

- Laravel 9.x
- Bootstrap 5
- OpenWeatherMap API
- HTML5
- CSS3
- JavaScript

## Tips

- API key gratis memiliki batasan 60 request per menit
- Data cuaca di-cache untuk mengurangi API call
- Gunakan geolocation untuk mendapatkan cuaca lokal otomatis

## Troubleshooting

### Error: "API key not found"
- Pastikan `OPENWEATHER_API_KEY` ada di `.env`
- Restart Laravel development server

### Error: "Connection timeout"
- Periksa koneksi internet
- Pastikan OpenWeatherMap API dapat diakses

### Forecast tidak tampil
- Beberapa plan API OpenWeatherMap tidak include forecast
- Upgrade ke plan berbayar jika diperlukan

## License

MIT
