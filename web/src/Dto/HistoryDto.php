<?php

declare(strict_types=1);

namespace App\Dto;

use DateTimeImmutable;

class HistoryDto
{
    public function __construct(
        public readonly string            $temperature,
        public readonly int               $cloudiness,
        public readonly string            $wind,
        public readonly string            $description,
        public readonly string            $lat,
        public readonly string            $lng,
        public readonly string            $city,
        public readonly DateTimeImmutable $dateTime
    )
    {
    }
}
