<?php

declare(strict_types=1);

namespace App\Serializer\Normalizer;

use App\Dto\WeatherDto;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class WeatherDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): WeatherDto
    {
        $temperature = $data['main']['temp'];
        $cloudiness = $data['clouds']['all'];
        $wind = $data['wind']['speed'];
        $description = $data['weather'][0]['description'];
        $name = $data['name'];

        return new $type($temperature, $cloudiness, $wind, $description, $name);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return WeatherDto::class === $type;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            WeatherDto::class => true
        ];
    }
}
