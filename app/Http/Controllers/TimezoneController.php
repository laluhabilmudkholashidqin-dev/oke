<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TimezoneController extends Controller
{
    public function list()
    {
        $timezones = [
            // Asia
            ['name' => 'Asia/Jakarta', 'label' => 'Jakarta (UTC+7)', 'offset' => 7],
            ['name' => 'Asia/Bangkok', 'label' => 'Bangkok (UTC+7)', 'offset' => 7],
            ['name' => 'Asia/Shanghai', 'label' => 'Shanghai (UTC+8)', 'offset' => 8],
            ['name' => 'Asia/Tokyo', 'label' => 'Tokyo (UTC+9)', 'offset' => 9],
            ['name' => 'Asia/Seoul', 'label' => 'Seoul (UTC+9)', 'offset' => 9],
            ['name' => 'Asia/Hong_Kong', 'label' => 'Hong Kong (UTC+8)', 'offset' => 8],
            ['name' => 'Asia/Singapore', 'label' => 'Singapore (UTC+8)', 'offset' => 8],
            ['name' => 'Asia/Dubai', 'label' => 'Dubai (UTC+4)', 'offset' => 4],
            ['name' => 'Asia/Kolkata', 'label' => 'India (UTC+5:30)', 'offset' => 5.5],
            ['name' => 'Asia/Manila', 'label' => 'Manila (UTC+8)', 'offset' => 8],
            ['name' => 'Asia/Kuala_Lumpur', 'label' => 'Kuala Lumpur (UTC+8)', 'offset' => 8],
            ['name' => 'Asia/Taipei', 'label' => 'Taipei (UTC+8)', 'offset' => 8],
            ['name' => 'Asia/Istanbul', 'label' => 'Istanbul (UTC+3)', 'offset' => 3],
            ['name' => 'Asia/Karachi', 'label' => 'Karachi (UTC+5)', 'offset' => 5],
            ['name' => 'Asia/Tehran', 'label' => 'Tehran (UTC+3:30)', 'offset' => 3.5],
            
            // Europe
            ['name' => 'Europe/London', 'label' => 'London (UTC+0)', 'offset' => 0],
            ['name' => 'Europe/Paris', 'label' => 'Paris (UTC+1)', 'offset' => 1],
            ['name' => 'Europe/Berlin', 'label' => 'Berlin (UTC+1)', 'offset' => 1],
            ['name' => 'Europe/Moscow', 'label' => 'Moscow (UTC+3)', 'offset' => 3],
            ['name' => 'Europe/Amsterdam', 'label' => 'Amsterdam (UTC+1)', 'offset' => 1],
            ['name' => 'Europe/Brussels', 'label' => 'Brussels (UTC+1)', 'offset' => 1],
            ['name' => 'Europe/Vienna', 'label' => 'Vienna (UTC+1)', 'offset' => 1],
            ['name' => 'Europe/Prague', 'label' => 'Prague (UTC+1)', 'offset' => 1],
            ['name' => 'Europe/Warsaw', 'label' => 'Warsaw (UTC+1)', 'offset' => 1],
            ['name' => 'Europe/Rome', 'label' => 'Rome (UTC+1)', 'offset' => 1],
            ['name' => 'Europe/Madrid', 'label' => 'Madrid (UTC+1)', 'offset' => 1],
            ['name' => 'Europe/Athens', 'label' => 'Athens (UTC+2)', 'offset' => 2],
            ['name' => 'Europe/Istanbul', 'label' => 'Istanbul (UTC+3)', 'offset' => 3],
            
            // Americas
            ['name' => 'America/New_York', 'label' => 'New York (UTC-5)', 'offset' => -5],
            ['name' => 'America/Chicago', 'label' => 'Chicago (UTC-6)', 'offset' => -6],
            ['name' => 'America/Denver', 'label' => 'Denver (UTC-7)', 'offset' => -7],
            ['name' => 'America/Los_Angeles', 'label' => 'Los Angeles (UTC-8)', 'offset' => -8],
            ['name' => 'America/Toronto', 'label' => 'Toronto (UTC-5)', 'offset' => -5],
            ['name' => 'America/Vancouver', 'label' => 'Vancouver (UTC-8)', 'offset' => -8],
            ['name' => 'America/Mexico_City', 'label' => 'Mexico City (UTC-6)', 'offset' => -6],
            ['name' => 'America/São_Paulo', 'label' => 'São Paulo (UTC-3)', 'offset' => -3],
            ['name' => 'America/Buenos_Aires', 'label' => 'Buenos Aires (UTC-3)', 'offset' => -3],
            
            // Africa
            ['name' => 'Africa/Cairo', 'label' => 'Cairo (UTC+2)', 'offset' => 2],
            ['name' => 'Africa/Lagos', 'label' => 'Lagos (UTC+1)', 'offset' => 1],
            ['name' => 'Africa/Johannesburg', 'label' => 'Johannesburg (UTC+2)', 'offset' => 2],
            ['name' => 'Africa/Nairobi', 'label' => 'Nairobi (UTC+3)', 'offset' => 3],
            
            // Australia
            ['name' => 'Australia/Sydney', 'label' => 'Sydney (UTC+10)', 'offset' => 10],
            ['name' => 'Australia/Melbourne', 'label' => 'Melbourne (UTC+10)', 'offset' => 10],
            ['name' => 'Australia/Brisbane', 'label' => 'Brisbane (UTC+10)', 'offset' => 10],
            ['name' => 'Australia/Perth', 'label' => 'Perth (UTC+8)', 'offset' => 8],
            
            // Pacific
            ['name' => 'Pacific/Auckland', 'label' => 'Auckland (UTC+12)', 'offset' => 12],
            ['name' => 'Pacific/Fiji', 'label' => 'Fiji (UTC+12)', 'offset' => 12],
        ];

        return response()->json($timezones);
    }

    public function getOffset(Request $request)
    {
        $validated = $request->validate([
            'timezone' => 'required|string'
        ]);

        try {
            $dt = new \DateTime('now', new \DateTimeZone($validated['timezone']));
            $offset = $dt->getOffset();
            $hours = intdiv($offset, 3600);
            $minutes = intdiv(abs($offset) % 3600, 60);

            return response()->json([
                'success' => true,
                'timezone' => $validated['timezone'],
                'offset' => $offset,
                'offset_display' => sprintf('UTC%+d:%02d', $hours, $minutes)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid timezone'
            ], 400);
        }
    }
}
