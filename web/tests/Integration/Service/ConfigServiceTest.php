<?php

declare(strict_types=1);

namespace App\Tests\Integration\Service;

use App\Service\ConfigService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ConfigServiceTest extends KernelTestCase
{
    private ConfigService $configService;

    protected function setUp(): void
    {
        $container = static::getContainer();

        $this->configService = $container->get(ConfigService::class);
    }

    /**
     * @covers ConfigService::getGoogleMapApiKey
     */
    public function testGetGoogleMapApiKey(): void
    {
        $googleMapApiKey = $this->configService->getGoogleMapApiKey();

        $this->assertEquals('google_map_api_key', $googleMapApiKey);
    }

    /**
     * @covers ConfigService::getOpenWeatherMapApiKey
     */
    public function testGetOpenWeatherMapApiKey(): void
    {
        $openWeatherMapApiKey = $this->configService->getOpenWeatherMapApiKey();

        $this->assertEquals('open_weather_map_api_key', $openWeatherMapApiKey);
    }
}
