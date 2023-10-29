<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Controller\ApiController;
use App\Dto\HistoryDto;
use App\Dto\StatsDto;
use App\Dto\WeatherDto;
use App\Service\HistoryService;
use App\Service\WeatherService;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class ApiControllerTest extends WebTestCase
{
    /**
     * @covers ApiController::googleMap
     */
    public function testGoogleMap(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/api/google-map');

        $response = $client->getResponse();
        $result = $response->getContent();

        self::assertResponseIsSuccessful();
        self::assertJson($result);
        self::assertJsonStringEqualsJsonString('"google_map_api_key"', $result);
    }

    /**
     * @covers ApiController::weather
     */
    public function testWeather(): void
    {
        $client = static::createClient();
        $container = static::getContainer();

        $weatherServiceMock = $this->getMockBuilder(WeatherService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getWeatherData'])
            ->getMock();
        $weatherServiceMock->expects(self::once())
            ->method('getWeatherData')
            ->with([
                'lat' => '58.87578338090383',
                'lon' => '43.93937285423277'
            ])
            ->willReturn(new WeatherDto(
                2.7,
                100,
                4.09,
                'overcast clouds',
                'Kharp'
            ));
        $container->set(WeatherService::class, $weatherServiceMock);

        $client->request(Request::METHOD_GET, '/api/weather', [
            'lat' => '58.87578338090383',
            'lon' => '43.93937285423277'
        ]);
        $response = $client->getResponse();
        $result = $response->getContent();

        self::assertResponseIsSuccessful();
        self::assertJson($result);
        self::assertJsonStringEqualsJsonString(
            '{"temperature":2.7,"cloudiness":100,"wind":4.09,"description":"overcast clouds","name":"Kharp"}',
            $result
        );
    }

    /**
     * @covers ApiController::history
     */
    public function testHistory(): void
    {
        $client = static::createClient();
        $container = static::getContainer();

        $data = [
            'temperature' => '-11.75',
            'cloudiness' => 32,
            'wind' => '3.13',
            'description' => 'scattered clouds',
            'lat' => '70.35908536784788',
            'lng' => '93.07022150039671',
            'city' => 'Talnakh',
            'dateTime' => '30.08.2023, 18:30:45'
        ];

        $historyServiceMock = $this->getMockBuilder(HistoryService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['saveHistory'])
            ->getMock();
        $container->set(HistoryService::class, $historyServiceMock);

        $client->request(
            Request::METHOD_POST,
            '/api/history',
            [],
            [],
            [],
            json_encode($data, JSON_THROW_ON_ERROR)
        );
        $response = $client->getResponse();
        $result = $response->getContent();

        self::assertResponseIsSuccessful();
        self::assertJson($result);
        self::assertJsonStringEqualsJsonString('{"status": 200}', $result);
    }

    /**
     * @covers ApiController::histories
     */
    public function testHistories(): void
    {
        $client = static::createClient();
        $container = static::getContainer();

        $historyServiceMock = $this->getMockBuilder(HistoryService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getHistories'])
            ->getMock();
        $historyServiceMock->expects(self::once())
            ->method('getHistories')
            ->willReturn([
                new HistoryDto(
                    '34.35',
                    10,
                    '4.20',
                    'clear sky',
                    '38.5246734836877140',
                    '57.8116359868613260',
                    'Paris',
                    new DateTimeImmutable('2023-08-22T14:21:12+00:00')
                ),
                new HistoryDto(
                    '27.58',
                    60,
                    '2.30',
                    'broken clouds',
                    '46.5567087735230800',
                    '36.3280361461639250',
                    'Rome',
                    new DateTimeImmutable('2023-08-25T17:33:10+00:00')
                )
            ]);
        $container->set(HistoryService::class, $historyServiceMock);

        $client->request(Request::METHOD_GET, '/api/histories');
        $response = $client->getResponse();
        $result = $response->getContent();

        self::assertResponseIsSuccessful();
        self::assertJson($result);
        self::assertJsonStringEqualsJsonString(
            <<<EOD
            [
                {
                    "temperature": "34.35",
                    "cloudiness": 10,
                    "wind": "4.20",
                    "description": "clear sky",
                    "lat": "38.5246734836877140",
                    "lng": "57.8116359868613260",
                    "city": "Paris",
                    "dateTime": "2023-08-22T14:21:12+00:00"
                },
                {
                    "temperature": "27.58",
                    "cloudiness": 60,
                    "wind": "2.30",
                    "description": "broken clouds",
                    "lat": "46.5567087735230800",
                    "lng": "36.3280361461639250",
                    "city": "Rome",
                    "dateTime": "2023-08-25T17:33:10+00:00"
                }
            ]
            EOD,
            $result
        );
    }

    /**
     * @covers ApiController::stats
     */
    public function testStats(): void
    {
        $client = static::createClient();
        $container = static::getContainer();

        $historyServiceMock = $this->getMockBuilder(HistoryService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getStats'])
            ->getMock();
        $historyServiceMock->expects(self::once())
            ->method('getStats')
            ->willReturn(
                new StatsDto(
                    '3.87',
                    '12.34',
                    8.25,
                    'Helsinki'
                )
            );
        $container->set(HistoryService::class, $historyServiceMock);

        $client->request(Request::METHOD_GET, '/api/stats');
        $response = $client->getResponse();
        $result = $response->getContent();

        self::assertResponseIsSuccessful();
        self::assertJson($result);
        self::assertJsonStringEqualsJsonString(
            <<<EOD
            {
                "minTemperature": "3.87",
                "maxTemperature": "12.34",
                "avgTemperature": 8.25,
                "mostFrequentCity": "Helsinki"
            }
            EOD,
            $result
        );
    }
}
