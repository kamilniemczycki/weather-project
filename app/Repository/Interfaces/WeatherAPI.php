<?php

namespace App\Repository\Interfaces;

use App\Exceptions\NotFoundLocation;

interface WeatherAPI
{
    /**
     * @throws NotFoundLocation
     */
    public function find(string $slug_name);
    public function unSlugCity(string $slug_name): string;
    public function statusCode(): int;
}
