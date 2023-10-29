<?php

declare(strict_types=1);

namespace App\Tests\Unit\Serializer\Normalizer;

use App\Dto\WeatherDto;
use App\Serializer\Normalizer\WeatherDenormalizer;
use PHPUnit\Framework\TestCase;

class WeatherDenormalizerTest extends TestCase
{
    private WeatherDenormalizer $weatherDenormalizer;

    protected function setUp(): void
    {
        $this->weatherDenormalizer = new WeatherDenormalizer();
    }

    /**
     * @covers WeatherDenormalizer::denormalize
     */
    public function testDenormalize(): void
    {
        $data = [
            'main' => [
                'temp' => 2.7
            ],
            'clouds' => [
                'all' => 100
            ],
            'wind' => [
                'speed' => 4.09
            ],
            'weather' => [
                [
                    'description' => 'overcast clouds'
                ]
            ],
            'name' => 'Kharp'
        ];

        $weatherDto = $this->weatherDenormalizer->denormalize($data, WeatherDto::class);

        $this->assertInstanceOf(WeatherDto::class, $weatherDto);
        $this->assertEquals(2.7, $weatherDto->temperature);
        $this->assertEquals(100, $weatherDto->cloudiness);
        $this->assertEquals(4.09, $weatherDto->wind);
        $this->assertEquals('overcast clouds', $weatherDto->description);
        $this->assertEquals('Kharp', $weatherDto->name);
    }
}
