<?php

namespace Tests\Unit;

use App\Exceptions\NotFoundLocation;
use App\src\Downloader\WeatherDownloader;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class WeatherDownloaderTest extends TestCase
{
    /**
     * @dataProvider provider_weather_data
     * @throws \App\Exceptions\NotFoundLocation
     */
    public function test_weather_downloader($responseData)
    {
        Http::fake([
            'https://wttr.in/jelenia-gora?format=j1',
            Http::response($responseData, 200)
        ]);

        $weatherDownloader = new WeatherDownloader();
        $weather = $weatherDownloader->searchWeather('jelenia-gora');
        $this->assertEquals('Jelenia Gora', $weather->getCity());
        $this->assertEquals('Poland', $weather->getCountry());
        $this->assertEquals('Cloud', $weather->getWeatherDesc());
        $this->assertEquals('14', $weather->getTempC());
        $this->assertEquals('63', $weather->getTempF());
    }

    /**
     * @dataProvider provider_weather_data
     */
    public function test_not_found_weather_downloader($responseData)
    {
        $this->expectException(NotFoundLocation::class);
        Http::fake([
            'https://wttr.in/jelenia-gora?format=j1',
            Http::response('', 200)
        ]);

        $weatherDownloader = new WeatherDownloader();
        $weatherDownloader->searchWeather('jelenia-gora');

        Http::fake([
            'https://wttr.in/legnica?format=j1',
            Http::response($responseData, 404)
        ]);

        $weatherDownloader = new WeatherDownloader();
        $weatherDownloader->searchWeather('legnica');
    }

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
