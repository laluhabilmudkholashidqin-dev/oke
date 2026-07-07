<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Digital Clock</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        body.light-mode {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }

        body.neon-mode {
            background: #0a0e27;
        }

        body.glassmorphism-mode {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            backdrop-filter: blur(10px);
        }

        .navbar {
            background: rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
        }

        .container-main {
            padding: 40px 0;
        }

        .digital-clock-container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 50px;
            text-align: center;
            color: white;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 30px;
        }

        .light-mode .digital-clock-container {
            background: white;
            color: #333;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .neon-mode .digital-clock-container {
            background: rgba(0, 0, 0, 0.5);
            border: 2px solid #00ff88;
            color: #00ff88;
            text-shadow: 0 0 10px #00ff88;
        }

        .digital-time {
            font-size: 5rem;
            font-weight: 700;
            letter-spacing: 10px;
            font-family: 'Courier New', monospace;
            margin: 20px 0;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }

        .digital-date {
            font-size: 1.3rem;
            opacity: 0.9;
            margin-bottom: 10px;
        }

        .timezone-info {
            font-size: 1rem;
            opacity: 0.8;
        }

        .analog-clock-container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 350px;
            margin-bottom: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .light-mode .analog-clock-container {
            background: white;
        }

        #analogClock {
            width: 250px;
            height: 250px;
            background: white;
            border-radius: 50%;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        .timezone-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            color: white;
            margin-bottom: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .light-mode .timezone-card {
            background: white;
            color: #333;
        }

        .neon-mode .timezone-card {
            background: rgba(0, 0, 0, 0.5);
            border: 1px solid #00ff88;
            color: #00ff88;
        }

        .timezone-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .timezone-card h5 {
            margin-bottom: 10px;
            font-weight: 600;
        }

        .timezone-time {
            font-size: 1.8rem;
            font-family: 'Courier New', monospace;
            font-weight: 700;
            margin: 10px 0;
        }

        .timezone-offset {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .control-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .btn-custom {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .light-mode .btn-custom {
            background: #667eea;
            border: none;
            color: white;
        }

        .btn-custom:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .light-mode .btn-custom:hover {
            background: #764ba2;
        }

        .format-toggle {
            display: inline-flex;
            gap: 5px;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            padding: 5px;
        }

        .format-toggle button {
            background: transparent;
            border: none;
            color: white;
            padding: 8px 15px;
            cursor: pointer;
            border-radius: 5px;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .format-toggle button.active {
            background: rgba(255, 255, 255, 0.3);
        }

        .section-title {
            color: white;
            font-weight: 700;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        .light-mode .section-title {
            color: #333;
        }

        .neon-mode .section-title {
            color: #00ff88;
            text-shadow: 0 0 10px #00ff88;
        }

        .tabs-container {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .tab-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .tab-btn.active {
            background: rgba(255, 255, 255, 0.4);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .stopwatch-display {
            font-size: 3rem;
            font-family: 'Courier New', monospace;
            font-weight: 700;
            margin: 20px 0;
            color: white;
        }

        .light-mode .stopwatch-display {
            color: #333;
        }

        .neon-mode .stopwatch-display {
            color: #00ff88;
            text-shadow: 0 0 10px #00ff88;
        }

        footer {
            background: rgba(0, 0, 0, 0.3);
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 50px;
        }

        .favorites-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .favorite-item {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            padding: 15px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .favorite-item:hover {
            transform: translateY(-3px);
            background: rgba(255, 255, 255, 0.15);
        }

        @media (max-width: 768px) {
            .digital-time {
                font-size: 3rem;
            }

            .digital-clock-container {
                padding: 30px;
            }

            .analog-clock-container {
                height: 300px;
            }

            #analogClock {
                width: 200px;
                height: 200px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('clock.index') }}">
                <i class="bi bi-clock-history"></i> Digital Clock
            </a>
            <div class="ms-auto d-flex gap-2">
                <button class="btn-custom" onclick="toggleTheme()">
                    <i class="bi bi-moon"></i> Theme
                </button>
                <button class="btn-custom" onclick="toggleClockType()">
                    <i class="bi bi-diagram-2"></i> View
                </button>
                <button class="btn-custom" onclick="toggleFullscreen()">
                    <i class="bi bi-fullscreen"></i>
                </button>
            </div>
        </div>
    </nav>

    <div class="container-main">
        <div class="container">
            @yield('content')
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Digital Clock Multi-Timezone. Powered by Laravel.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentTheme = localStorage.getItem('clockTheme') || 'dark';
        let currentFormat = localStorage.getItem('timeFormat') || '24h';
        let clockType = localStorage.getItem('clockType') || 'digital';

        // Load theme on page load
        window.addEventListener('load', () => {
            applyTheme(currentTheme);
            applyFormat(currentFormat);
        });

        function toggleTheme() {
            const themes = ['dark', 'light', 'neon', 'glassmorphism'];
            const currentIndex = themes.indexOf(currentTheme);
            currentTheme = themes[(currentIndex + 1) % themes.length];
            localStorage.setItem('clockTheme', currentTheme);
            applyTheme(currentTheme);
        }

        function applyTheme(theme) {
            document.body.className = '';
            if (theme === 'light') {
                document.body.classList.add('light-mode');
            } else if (theme === 'neon') {
                document.body.classList.add('neon-mode');
            } else if (theme === 'glassmorphism') {
                document.body.classList.add('glassmorphism-mode');
            }
        }

        function toggleClockType() {
            clockType = clockType === 'digital' ? 'analog' : 'digital';
            localStorage.setItem('clockType', clockType);
            location.reload();
        }

        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(err => {
                    console.log(`Error attempting to enable fullscreen: ${err.message}`);
                });
            } else {
                document.exitFullscreen();
            }
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            if (e.key === 't' || e.key === 'T') toggleTheme();
            if (e.key === 'd' || e.key === 'D') toggleClockType();
            if (e.key === 'f' || e.key === 'F') toggleFullscreen();
        });
    </script>
    @yield('scripts')
</body>
</html>
