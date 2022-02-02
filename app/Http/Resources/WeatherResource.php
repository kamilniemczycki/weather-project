<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class WeatherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|Arrayable|JsonSerializable
    {
        return [
            'city' => $this->city,
            'city_slug' => $this->city_slug,
            'country' => $this->country,
            'weather_desc' => $this->weather_desc,
            'temp_c' => $this->temp_c,
            'temp_f' => $this->temp_f
        ];
    }
}
