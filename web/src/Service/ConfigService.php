<?php

declare(strict_types=1);

namespace App\Service;

class ConfigService
{
    public function __construct(
        private readonly string $googleMapApiKey,
        private readonly string $openWeatherMapApiKey
    )
    {
    }

    public function getGoogleMapApiKey(): string
    {
        return $this->googleMapApiKey;
    }

    public function getOpenWeatherMapApiKey(): string
    {
        return $this->openWeatherMapApiKey;
    }
}
