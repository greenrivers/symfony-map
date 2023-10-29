<?php

declare(strict_types=1);

namespace App\Dto;

class WeatherDto
{
    public function __construct(
        public readonly float  $temperature,
        public readonly int    $cloudiness,
        public readonly float  $wind,
        public readonly string $description,
        public readonly string $name
    )
    {
    }
}
