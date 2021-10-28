<?php

declare(strict_types=1);

namespace App\Interfaces\Downloader;

interface WeatherParser extends StatusCode, WeatherData
{
    public function unSlugCity(string $slugCity): string;
}
