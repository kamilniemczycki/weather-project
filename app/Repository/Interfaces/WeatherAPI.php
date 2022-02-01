<?php

namespace App\Repository\Interfaces;

interface WeatherAPI
{
    public function find(string $slug_name);
    public function unSlugCity(string $slug_name): string;
    public function statusCode(): int;
}
