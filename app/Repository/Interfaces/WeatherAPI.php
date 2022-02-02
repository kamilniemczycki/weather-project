<?php

declare(strict_types=1);

namespace App\Repository\Interfaces;

use App\Exceptions\NotFoundLocation;

interface WeatherAPI
{
    /**
     * @throws NotFoundLocation
     */
    public function find(string $slug_name);
    public function statusCode(): int;
}
