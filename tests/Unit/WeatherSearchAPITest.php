<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\SearchController;
use App\src\Downloader\WeatherDownloader;
use Illuminate\Support\Facades\Http;

class WeatherSearchAPITest extends TestCaseWithWeatherData
{
    /**
     * @dataProvider provider_weather_data
     */
    public function test_search_weather($providerData)
    {
        Http::fake([
            'https://wttr.in/jelenia-gora?format=j1',
            Http::response($providerData, 200)
        ]);
        $weatherDownloader = new WeatherDownloader();
        $searchController = new SearchController();
        $response = $searchController->show('jelenia-gora', $weatherDownloader);

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @dataProvider provider_weather_data
     */
    public function test_not_found_search_weather($providerData)
    {
        Http::fake([
            'https://wttr.in/jelenia-gora?format=j1',
            Http::response('', 404)
        ]);
        $weatherDownloader = new WeatherDownloader();
        $searchController = new SearchController();
        $response = $searchController->show('jelenia-gora', $weatherDownloader);

        $this->assertEquals(404, $response->getStatusCode());
    }
}
