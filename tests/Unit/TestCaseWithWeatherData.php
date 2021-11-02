<?php

namespace Tests\Unit;

use Tests\TestCase;

class TestCaseWithWeatherData extends TestCase
{
    public function provider_weather_data(): array
    {
        $data = [
            'city' => 'jelenie-gora',
            'nearest_area' => [
                0 => [
                    'country' => [
                        0 => [
                            'value' => 'Poland'
                        ]
                    ]
                ]
            ],
            'current_condition' => [
                0 => [
                    'weatherDesc' => [
                        0 => [
                            'value' => 'Cloud'
                        ]
                    ],
                    'temp_C' => '14',
                    'temp_F' => '63'
                ]
            ]
        ];
        return [
            [
                $data
            ]
        ];
    }
}
