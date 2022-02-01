<?php

namespace App\Repository\Interfaces;

interface WeatherAPI
{
    public function find(string $slug_name);
}
