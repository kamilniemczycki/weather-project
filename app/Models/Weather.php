<?php

namespace App\Models;

/**
 * @property string $city
 * @property string $country
 * @property string $weather_desc
 * @property int $temp_c
 * @property int $temp_f
 */
class Weather extends SmallModel
{
    protected $guarded = [];
    protected $casts = [
        'temp_c' => 'integer',
        'temp_f' => 'integer'
    ];
}
