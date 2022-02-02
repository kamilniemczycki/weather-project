<?php

namespace App\Console\Commands;

use App\Exceptions\NotFoundLocation;
use App\Models\Weather;
use App\Repository\Interfaces\WeatherAPI;
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
     * @param WeatherAPI $api
     * @return int
     */
    public function handle(WeatherAPI $api): int
    {
        try {
            $weather = $this->getWeather($api);
            print 'City: ' . $weather->city . PHP_EOL;
            print 'City slug: ' . $weather->city_slug . PHP_EOL;
            print 'Country: ' . $weather->country . PHP_EOL;
            print 'Weather: ' . $weather->weather_desc . PHP_EOL;
            print 'Temp: ' . $weather->temp_c . ' °C (' . $weather->temp_f . ' °F)' . PHP_EOL;
        } catch (NotFoundLocation $e) {
            print $e->getMessage();
        }

        return 0;
    }

    /**
     * @param WeatherAPI $api
     * @return Weather
     * @throws NotFoundLocation
     */
    private function getWeather(WeatherAPI $api): Weather
    {
        $city = Str::slug($this->argument('city'));

        return $api->find($city);
    }
}
