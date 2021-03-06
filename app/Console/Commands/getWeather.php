<?php

namespace App\Console\Commands;

use App\Exceptions\NotFoundLocation;
use App\Interfaces\Downloader\WeatherDownloader;
use App\src\Weather;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class getWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:weather {city}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Displays the weather for a given city.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(WeatherDownloader $api): int
    {
        try {
            $weather = $this->getWeather($api);
            print 'City: ' . $weather->getCity() . PHP_EOL;
            print 'Country: ' . $weather->getCountry() . PHP_EOL;
            print 'Weather: ' . $weather->getWeatherDesc() . PHP_EOL;
            print 'Temp: ' . $weather->getTempC() . ' °C (' . $weather->getTempF() . ' °F)' . PHP_EOL;
        } catch (NotFoundLocation $e) {
            print $e->getMessage();
        }

        return 0;
    }

    /**
     * @throws \App\Exceptions\NotFoundLocation
     */
    private function getWeather(WeatherDownloader $api): Weather
    {
        $city = Str::slug($this->argument('city'));

        return $api->searchWeather($city);
    }
}
