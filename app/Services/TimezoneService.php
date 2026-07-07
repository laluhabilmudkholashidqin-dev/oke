<?php

namespace App\Services;

use DateTime;
use DateTimeZone;

class TimezoneService
{
    protected $timezones = [
        'Asia/Jakarta', 'Asia/Bangkok', 'Asia/Shanghai', 'Asia/Tokyo', 'Asia/Seoul',
        'Europe/London', 'Europe/Paris', 'Europe/Berlin', 'Europe/Moscow',
        'America/New_York', 'America/Chicago', 'America/Denver', 'America/Los_Angeles',
        'Australia/Sydney', 'Pacific/Auckland'
    ];

    public function getAllTimezones()
    {
        return $this->timezones;
    }

    public function getTimeInTimezone($timezone, $format = '24h')
    {
        try {
            $dt = new DateTime('now', new DateTimeZone($timezone));

            if ($format === '12h') {
                return [
                    'time' => $dt->format('h:i:s A'),
                    'date' => $dt->format('l, d F Y'),
                    'timezone' => $timezone,
                    'offset' => $this->getTimezoneOffset($timezone)
                ];
            }

            return [
                'time' => $dt->format('H:i:s'),
                'date' => $dt->format('l, d F Y'),
                'timezone' => $timezone,
                'offset' => $this->getTimezoneOffset($timezone)
            ];
        } catch (\Exception $e) {
            throw new \Exception('Invalid timezone: ' . $timezone);
        }
    }

    public function getTimezoneOffset($timezone)
    {
        try {
            $dt = new DateTime('now', new DateTimeZone($timezone));
            $offset = $dt->getOffset();
            $hours = intdiv($offset, 3600);
            $minutes = intdiv(abs($offset) % 3600, 60);

            return sprintf('UTC%+d:%02d', $hours, $minutes);
        } catch (\Exception $e) {
            return 'UTC+0:00';
        }
    }

    public function getTimezoneList()
    {
        return [
            'Asia' => [
                'Asia/Jakarta' => 'Jakarta',
                'Asia/Bangkok' => 'Bangkok',
                'Asia/Shanghai' => 'Shanghai',
                'Asia/Tokyo' => 'Tokyo',
                'Asia/Seoul' => 'Seoul',
                'Asia/Hong_Kong' => 'Hong Kong',
                'Asia/Singapore' => 'Singapore',
                'Asia/Dubai' => 'Dubai',
                'Asia/Kolkata' => 'India',
                'Asia/Manila' => 'Manila',
            ],
            'Europe' => [
                'Europe/London' => 'London',
                'Europe/Paris' => 'Paris',
                'Europe/Berlin' => 'Berlin',
                'Europe/Moscow' => 'Moscow',
                'Europe/Amsterdam' => 'Amsterdam',
                'Europe/Rome' => 'Rome',
                'Europe/Madrid' => 'Madrid',
            ],
            'Americas' => [
                'America/New_York' => 'New York',
                'America/Chicago' => 'Chicago',
                'America/Denver' => 'Denver',
                'America/Los_Angeles' => 'Los Angeles',
                'America/Toronto' => 'Toronto',
                'America/Mexico_City' => 'Mexico City',
            ],
            'Australia' => [
                'Australia/Sydney' => 'Sydney',
                'Australia/Melbourne' => 'Melbourne',
                'Australia/Perth' => 'Perth',
            ]
        ];
    }
}
