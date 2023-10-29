<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\ErrorDto;
use App\Dto\WeatherDto;
use App\Serializer\DtoSerializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class WeatherService
{
    public const OPEN_WEATHER_MAP_URL = 'https://api.openweathermap.org/data/2.5/weather';

    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly ConfigService       $configService,
        private readonly DtoSerializer       $dtoSerializer
    )
    {
    }

    public function getWeatherData(array $params): WeatherDto|ErrorDto
    {
        $data = $this->makeRequest($params)
            ->toArray(false);

        $type = ($data['cod'] === Response::HTTP_OK) ? WeatherDto::class : ErrorDto::class;
        return $this->dtoSerializer->denormalize($data, $type);
    }

    private function makeRequest(array $params): ResponseInterface
    {
        $params['appid'] = $this->configService->getOpenWeatherMapApiKey();
        $params['units'] = 'metric';

        return $this->client->request(Request::METHOD_POST, self::OPEN_WEATHER_MAP_URL, [
            'query' => $params
        ]);
    }
}
