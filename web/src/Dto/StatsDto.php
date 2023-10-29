<?php

declare(strict_types=1);

namespace App\Dto;

class StatsDto
{
    public function __construct(
        public readonly string $minTemperature,
        public readonly string $maxTemperature,
        public readonly float  $avgTemperature,
        public readonly string $mostFrequentCity
    )
    {
    }
}
