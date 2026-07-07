<?php

namespace App\Http\Controllers;

use App\Services\TimezoneService;
use Illuminate\Http\Request;

class ClockController extends Controller
{
    protected $timezoneService;

    public function __construct(TimezoneService $timezoneService)
    {
        $this->timezoneService = $timezoneService;
    }

    public function index()
    {
        $timezones = $this->timezoneService->getAllTimezones();
        $defaultTimezone = 'Asia/Jakarta';
        $currentTime = $this->timezoneService->getTimeInTimezone($defaultTimezone);

        return view('clock.index', [
            'timezones' => $timezones,
            'defaultTimezone' => $defaultTimezone,
            'currentTime' => $currentTime
        ]);
    }

    public function getTime()
    {
        return response()->json([
            'timestamp' => now()->timestamp,
            'datetime' => now()->toIso8601String(),
            'time' => now()->format('H:i:s')
        ]);
    }

    public function getTimeInTimezone(Request $request)
    {
        $validated = $request->validate([
            'timezone' => 'required|string',
            'format' => 'nullable|in:12h,24h'
        ]);

        try {
            $time = $this->timezoneService->getTimeInTimezone(
                $validated['timezone'],
                $validated['format'] ?? '24h'
            );

            return response()->json([
                'success' => true,
                'timezone' => $validated['timezone'],
                'time' => $time,
                'timestamp' => now()->timestamp
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid timezone'
            ], 400);
        }
    }
}
