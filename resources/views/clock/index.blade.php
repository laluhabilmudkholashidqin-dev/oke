@extends('layouts.app')

@section('title', 'Digital Clock')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <!-- Tabs -->
        <div class="tabs-container">
            <button class="tab-btn active" onclick="switchTab('main')">
                <i class="bi bi-clock"></i> Jam
            </button>
            <button class="tab-btn" onclick="switchTab('multiple')">
                <i class="bi bi-globe"></i> Multi Zona
            </button>
            <button class="tab-btn" onclick="switchTab('stopwatch')">
                <i class="bi bi-stopwatch"></i> Stopwatch
            </button>
            <button class="tab-btn" onclick="switchTab('timer')">
                <i class="bi bi-hourglass"></i> Timer
            </button>
        </div>

        <!-- Main Tab -->
        <div id="main" class="tab-content active">
            <div class="digital-clock-container" id="mainClock">
                <div class="digital-date" id="currentDate">Loading...</div>
                <div class="digital-time" id="digitalTime">00:00:00</div>
                <div class="timezone-info" id="timezoneInfo">Asia/Jakarta</div>
                <div style="margin-top: 20px;">
                    <div class="format-toggle">
                        <button class="active" onclick="switchTimeFormat('24h', this)">24 Jam</button>
                        <button onclick="switchTimeFormat('12h', this)">12 Jam</button>
                    </div>
                </div>
            </div>

            <div class="analog-clock-container" id="analogClockContainer" style="display: none;">
                <canvas id="analogClock" width="250" height="250"></canvas>
            </div>

            <div style="text-align: center; margin-bottom: 20px;">
                <label for="timezoneSelect" style="color: white; margin-right: 10px;">
                    <i class="bi bi-geo-alt"></i> Pilih Zona Waktu:
                </label>
                <select id="timezoneSelect" onchange="changeTimezone(this.value)" style="padding: 8px; border-radius: 5px; border: none;">
                    <option>{{ $defaultTimezone }}</option>
                </select>
            </div>
        </div>

        <!-- Multiple Timezones Tab -->
        <div id="multiple" class="tab-content">
            <h3 class="section-title"><i class="bi bi-globe"></i> Berbagai Zona Waktu</h3>
            <div style="margin-bottom: 15px;">
                <input type="text" id="addTimezoneInput" placeholder="Cari dan tambah zona waktu..." 
                       style="padding: 10px; border-radius: 5px; border: none; width: 100%;">
            </div>
            <div id="multipleTimezonesContainer" class="timezone-card" style="background: rgba(255,255,255,0.05); padding: 20px;">
                <p style="color: rgba(255,255,255,0.6); text-align: center;">Klik tombol di atas untuk menambah zona waktu</p>
            </div>
        </div>

        <!-- Stopwatch Tab -->
        <div id="stopwatch" class="tab-content">
            <div class="digital-clock-container">
                <h3 class="section-title"><i class="bi bi-stopwatch"></i> Stopwatch</h3>
                <div class="stopwatch-display" id="stopwatchDisplay">00:00.00</div>
                <div class="control-buttons">
                    <button class="btn-custom" onclick="startStopwatch()"><i class="bi bi-play"></i> Start</button>
                    <button class="btn-custom" onclick="stopStopwatch()"><i class="bi bi-pause"></i> Stop</button>
                    <button class="btn-custom" onclick="resetStopwatch()"><i class="bi bi-arrow-counterclockwise"></i> Reset</button>
                </div>
            </div>
        </div>

        <!-- Timer Tab -->
        <div id="timer" class="tab-content">
            <div class="digital-clock-container">
                <h3 class="section-title"><i class="bi bi-hourglass"></i> Timer</h3>
                <div style="margin-bottom: 20px;">
                    <input type="number" id="timerMinutes" min="0" max="60" value="5" placeholder="Menit" 
                           style="padding: 10px; border-radius: 5px; border: none; width: 80px; margin-right: 10px;">
                    <input type="number" id="timerSeconds" min="0" max="59" value="0" placeholder="Detik" 
                           style="padding: 10px; border-radius: 5px; border: none; width: 80px;">
                </div>
                <div class="stopwatch-display" id="timerDisplay">05:00</div>
                <div class="control-buttons">
                    <button class="btn-custom" onclick="startTimer()"><i class="bi bi-play"></i> Start</button>
                    <button class="btn-custom" onclick="stopTimer()"><i class="bi bi-pause"></i> Pause</button>
                    <button class="btn-custom" onclick="resetTimer()"><i class="bi bi-arrow-counterclockwise"></i> Reset</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let stopwatchInterval;
    let timerInterval;
    let stopwatchMs = 0;
    let timerMs = 0;

    // Update main clock
    function updateMainClock() {
        const now = new Date();
        const tz = localStorage.getItem('selectedTimezone') || 'Asia/Jakarta';
        const format = currentFormat;

        fetch('{{ route("clock.timezone") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                timezone: tz,
                format: format
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('digitalTime').textContent = data.data.time;
                document.getElementById('currentDate').textContent = data.data.date;
                document.getElementById('timezoneInfo').textContent = data.timezone + ' (' + data.data.offset + ')';
            }
        });

        // Draw analog clock
        drawAnalogClock();
    }

    function drawAnalogClock() {
        const canvas = document.getElementById('analogClock');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        const radius = canvas.width / 2;
        const centerX = radius;
        const centerY = radius;

        // Clear
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Draw circle
        ctx.strokeStyle = '#333';
        ctx.lineWidth = 2;
        ctx.beginPath();
        ctx.arc(centerX, centerY, radius - 10, 0, 2 * Math.PI);
        ctx.stroke();

        // Draw numbers
        ctx.fillStyle = '#333';
        ctx.font = 'bold 14px Arial';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        for (let i = 1; i <= 12; i++) {
            const angle = (i - 3) * (Math.PI / 6);
            const x = centerX + (radius - 30) * Math.cos(angle);
            const y = centerY + (radius - 30) * Math.sin(angle);
            ctx.fillText(i, x, y);
        }

        const now = new Date();
        const hours = now.getHours() % 12;
        const minutes = now.getMinutes();
        const seconds = now.getSeconds();

        // Hour hand
        ctx.strokeStyle = '#333';
        ctx.lineWidth = 6;
        const hourAngle = (hours + minutes / 60) * (Math.PI / 6) - Math.PI / 2;
        ctx.beginPath();
        ctx.moveTo(centerX, centerY);
        ctx.lineTo(centerX + 70 * Math.cos(hourAngle), centerY + 70 * Math.sin(hourAngle));
        ctx.stroke();

        // Minute hand
        ctx.lineWidth = 4;
        const minuteAngle = (minutes + seconds / 60) * (Math.PI / 30) - Math.PI / 2;
        ctx.beginPath();
        ctx.moveTo(centerX, centerY);
        ctx.lineTo(centerX + 100 * Math.cos(minuteAngle), centerY + 100 * Math.sin(minuteAngle));
        ctx.stroke();

        // Second hand
        ctx.strokeStyle = 'red';
        ctx.lineWidth = 2;
        const secondAngle = seconds * (Math.PI / 30) - Math.PI / 2;
        ctx.beginPath();
        ctx.moveTo(centerX, centerY);
        ctx.lineTo(centerX + 110 * Math.cos(secondAngle), centerY + 110 * Math.sin(secondAngle));
        ctx.stroke();

        // Center dot
        ctx.fillStyle = '#333';
        ctx.beginPath();
        ctx.arc(centerX, centerY, 5, 0, 2 * Math.PI);
        ctx.fill();
    }

    function switchTimeFormat(format, btn) {
        currentFormat = format;
        localStorage.setItem('timeFormat', format);
        document.querySelectorAll('.format-toggle button').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        updateMainClock();
    }

    function changeTimezone(tz) {
        localStorage.setItem('selectedTimezone', tz);
        updateMainClock();
    }

    function switchTab(tabName) {
        document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        document.getElementById(tabName).classList.add('active');
        event.target.classList.add('active');
    }

    // Stopwatch functions
    function startStopwatch() {
        if (!stopwatchInterval) {
            stopwatchInterval = setInterval(() => {
                stopwatchMs += 10;
                updateStopwatchDisplay();
            }, 10);
        }
    }

    function stopStopwatch() {
        clearInterval(stopwatchInterval);
        stopwatchInterval = null;
    }

    function resetStopwatch() {
        stopStopwatch();
        stopwatchMs = 0;
        updateStopwatchDisplay();
    }

    function updateStopwatchDisplay() {
        const totalSeconds = Math.floor(stopwatchMs / 1000);
        const minutes = Math.floor(totalSeconds / 60);
        const seconds = totalSeconds % 60;
        const centiseconds = Math.floor((stopwatchMs % 1000) / 10);
        document.getElementById('stopwatchDisplay').textContent = 
            `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}.${String(centiseconds).padStart(2, '0')}`;
    }

    // Timer functions
    function startTimer() {
        if (!timerInterval) {
            timerInterval = setInterval(() => {
                if (timerMs > 0) {
                    timerMs -= 100;
                    updateTimerDisplay();
                } else {
                    stopTimer();
                    alert('Timer selesai!');
                }
            }, 100);
        }
    }

    function stopTimer() {
        clearInterval(timerInterval);
        timerInterval = null;
    }

    function resetTimer() {
        stopTimer();
        const minutes = parseInt(document.getElementById('timerMinutes').value) || 0;
        const seconds = parseInt(document.getElementById('timerSeconds').value) || 0;
        timerMs = (minutes * 60 + seconds) * 1000;
        updateTimerDisplay();
    }

    function updateTimerDisplay() {
        const totalSeconds = Math.floor(timerMs / 1000);
        const minutes = Math.floor(totalSeconds / 60);
        const seconds = totalSeconds % 60;
        document.getElementById('timerDisplay').textContent = 
            `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    }

    // Event listeners
    document.getElementById('timerMinutes')?.addEventListener('change', resetTimer);
    document.getElementById('timerSeconds')?.addEventListener('change', resetTimer);

    // Initialize
    updateMainClock();
    setInterval(updateMainClock, 1000);
    resetTimer();
</script>
@endsection
