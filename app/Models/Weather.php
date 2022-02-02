<?php

namespace App\Models;

use Illuminate\Support\Str;

/**
 * @property string $city
 * @property string $city_slug
 * @property string $country
 * @property string $weather_desc
 * @property int $temp_c
 * @property int $temp_f
 */
class Weather extends SmallModel
{
    protected $guarded = [];
    protected $casts = [
        'city' => 'string',
        'temp_c' => 'integer',
        'temp_f' => 'integer'
    ];

    public function getCityAttribute(string $value): string
    {
        return $this->unSlugCity($value);
    }

    public function getCitySlugAttribute(): string
    {
        return Str::slug($this->getAttribute('city'));
    }

    private function unSlugCity(string $slug_name): string
    {
        $parsed = '';
        foreach (explode('-', $slug_name) as $word)
            $parsed .= ucfirst($word) . ' ';

        return rtrim($parsed, " ");
    }
}
