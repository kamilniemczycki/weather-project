<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Attribute;
use App\Interfaces\Weather as WeatherInterface;

/**
 * Class Weather
 * @method bool setCity(string $city)
 * @method string|null getCity()
 *
 * @method bool setCountry(string $country)
 * @method string|null getCountry()
 *
 * @method bool setWeatherDesc(string $desc)
 * @method string|null getWeatherDesc()
 *
 * @method bool setTempC(string $tempC)
 * @method string|null getTempC()
 *
 * @method bool setTempF(string $tempF)
 * @method string|null getTempF()
 */
class Weather implements WeatherInterface
{
    use Attribute;

    /**
     * @param string|null $city
     * @param string|null $country
     * @param string|null $weatherDesc
     * @param string|null $tempC
     * @param string|null $tempF
     */
    public function __construct(
        protected ?string $city = null,
        protected ?string $country = null,
        protected ?string $weatherDesc = null,
        protected ?string $tempC = null,
        protected ?string $tempF = null
    ) {}

    public function getAll(): array
    {
        return get_object_vars($this);
    }
}
