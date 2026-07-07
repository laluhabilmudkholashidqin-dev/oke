# Digital Clock - Multi Timezone

Digital Clock adalah aplikasi web yang menampilkan waktu digital real-time dengan dukungan berbagai zona waktu di seluruh dunia.

## Fitur Utama

- ⏰ Jam digital real-time dengan format 12/24 jam
- 🌍 Dukungan 50+ zona waktu di seluruh dunia
- 🎨 Multiple theme color (Dark, Light, Neon, Glassmorphism)
- 📍 Tampilkan jam multiple timezone sekaligus
- ⭐ Simpan zona waktu favorit
- 🌓 Dark/Light mode toggle
- 📱 Responsive design
- 🎯 Analog & Digital clock display
- 📊 Current date dengan hari
- ⏱️ Stopwatch & Timer features
- 🔔 Alarm notifications
- 💾 Local storage untuk preferences

## Requirements

- PHP 8.0+
- Laravel 9.x+
- MySQL/MariaDB (optional)
- Modern web browser

## Instalasi

### 1. Clone Repository
```bash
git clone <repository-url>
cd digital-clock
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Jalankan Aplikasi
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
│   │       ├── ClockController.php
│   │       └── TimezoneController.php
│   └── Services/
│       └── TimezoneService.php
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   └── app.blade.php
│   │   └── clock/
│   │       ├── index.blade.php
│   │       └── components/
│   │           ├── digital-clock.blade.php
│   │           ├── analog-clock.blade.php
│   │           └── timezone-selector.blade.php
│   └── js/
│       ├── clock.js
│       ├── timezone.js
│       └── theme.js
├── routes/
│   └── web.php
└── .env.example
```

## Fitur Utama

### 1. 🕐 Digital Clock
- Tampilan jam digital real-time
- Format 12 jam / 24 jam
- Update setiap detik
- Menampilkan tanggal lengkap

### 2. 🕰️ Analog Clock
- Tampilan jam analog tradisional
- Jarum jam, menit, detik bergerak smooth
- Canvas rendering

### 3. 🌍 Multi Timezone
- Lebih dari 50 timezone
- Tampilkan jam di 3-5 zona waktu berbeda
- Quick timezone selection

### 4. ⭐ Favorit
- Simpan zona waktu favorit
- Quick access dengan 1 klik
- Manage favorit list

### 5. 🎨 Themes
- **Dark Mode**: Tema gelap elegan
- **Light Mode**: Tema terang bersih
- **Neon**: Gaya neon futuristik
- **Glassmorphism**: Modern glass effect

### 6. ⏱️ Stopwatch
- Start/Stop/Reset
- Lap timing
- Display format mm:ss.ms

### 7. ⏲️ Timer
- Set custom duration
- Countdown display
- Audio notification

### 8. 🔔 Alarm
- Set multiple alarms
- Time-based notifications
- Sound alerts

---

## API Endpoints

| Method | Endpoint | Deskripsi |
|--------|----------|----------|
| GET | `/` | Dashboard jam utama |
| GET | `/api/time` | Get current time (JSON) |
| GET | `/api/timezones` | Get list timezone |
| GET | `/api/time/{timezone}` | Get time specific timezone |
| POST | `/api/favorites` | Save favorite timezone |
| GET | `/api/favorites` | Get favorite list |
| DELETE | `/api/favorites/{id}` | Remove favorite |

---

## Timezone yang Didukung

### Asia
- Asia/Jakarta (UTC+7)
- Asia/Bangkok (UTC+7)
- Asia/Shanghai (UTC+8)
- Asia/Tokyo (UTC+9)
- Asia/Seoul (UTC+9)
- Asia/Hong_Kong (UTC+8)
- Asia/Singapore (UTC+8)
- Asia/Dubai (UTC+4)
- Asia/Kolkata (UTC+5:30)
- Dan lebih dari 40 timezone lainnya...

### Eropa
- Europe/London (UTC+0)
- Europe/Paris (UTC+1)
- Europe/Berlin (UTC+1)
- Europe/Moscow (UTC+3)
- Dan lebih dari 20 timezone lainnya...

### Amerika
- America/New_York (UTC-5)
- America/Chicago (UTC-6)
- America/Denver (UTC-7)
- America/Los_Angeles (UTC-8)
- America/Toronto (UTC-5)
- Dan lebih dari 20 timezone lainnya...

---

## Penggunaan

### 1. Tampilkan Jam Digital
```javascript
const clock = new DigitalClock({
    timezone: 'Asia/Jakarta',
    format: '24h', // atau '12h'
    theme: 'dark'
});
```

### 2. Tampilkan Jam Analog
```javascript
const analogClock = new AnalogClock({
    timezone: 'Asia/Jakarta',
    theme: 'dark'
});
```

### 3. Multiple Timezones
```javascript
const multiClock = new MultiTimezoneClock([
    'Asia/Jakarta',
    'Europe/London',
    'America/New_York'
]);
```

### 4. Stopwatch
```javascript
const stopwatch = new Stopwatch();
stopwatch.start();
stopwatch.stop();
stopwatch.reset();
```

### 5. Timer
```javascript
const timer = new Timer(300); // 5 menit
timer.start();
```

---

## Teknologi

- Laravel 9.x
- Bootstrap 5
- Vanilla JavaScript
- HTML5 Canvas
- CSS3 Animations
- Font Awesome Icons
- Local Storage API

---

## Keyboard Shortcuts

| Shortcut | Action |
|----------|--------|
| `T` | Toggle theme |
| `D` | Toggle digital/analog |
| `S` | Start/Stop stopwatch |
| `R` | Reset stopwatch |
| `A` | Add new timezone |
| `F` | Toggle favorites |
| `?` | Show help |

---

## Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

---

## Tips

1. **Daylight Saving Time**: Otomatis adjust untuk DST
2. **Offline Mode**: Bekerja offline setelah load pertama
3. **Performance**: Optimized dengan requestAnimationFrame
4. **Persistence**: Preferences tersimpan di localStorage

---

## Troubleshooting

### Jam tidak update
- Clear browser cache
- Refresh halaman
- Check console untuk error

### Timezone salah
- Verify browser timezone settings
- Update system time
- Clear localStorage

### Alarm tidak bunyi
- Check browser volume
- Verify notification permission
- Check audio file path

---

## License

MIT
