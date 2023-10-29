<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Dto\WeatherDto;
use App\Serializer\DtoSerializer;
use App\Service\ConfigService;
use App\Service\WeatherService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherServiceTest extends TestCase
{
    private WeatherService $weatherService;

    private HttpClientInterface|MockObject $clientMock;

    private ConfigService|MockObject $configServiceMock;

    private DtoSerializer|MockObject $dtoSerializerMock;

    protected function setUp(): void
    {
        $this->clientMock = new MockHttpClient();
        $this->configServiceMock = $this->getMockBuilder(ConfigService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->dtoSerializerMock = $this->getMockBuilder(DtoSerializer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->weatherService = new WeatherService(
            $this->clientMock,
            $this->configServiceMock,
            $this->dtoSerializerMock
        );
    }

    /**
     * @covers WeatherService::getWeatherData
     */
    public function testGetWeatherData(): void
    {
        $data = [
            'main' => [
                'temp' => '2.7'
            ],
            'clouds' => [
                'all' => 100
            ],
            'wind' => [
                'speed' => '4.09'
            ],
            'weather' => [
                [
                    'description' => 'overcast clouds'
                ]
            ],
            'name' => 'Kharp',
            'cod' => 200
        ];
        $this->clientMock->setResponseFactory([
            new MockResponse(json_encode($data, JSON_THROW_ON_ERROR))
        ]);
        $this->dtoSerializerMock->expects(self::once())
            ->method('denormalize')
            ->with($data)
            ->willReturn(new WeatherDto(
                2.7,
                100,
                4.09,
                'overcast clouds',
                'Kharp'
            ));

        $weatherDto = $this->weatherService->getWeatherData([
            'lat' => '58.87578338090383',
            'lon' => '43.93937285423277'
        ]);

        $this->assertInstanceOf(WeatherDto::class, $weatherDto);
        $this->assertEquals(2.7, $weatherDto->temperature);
        $this->assertEquals(100, $weatherDto->cloudiness);
        $this->assertEquals(4.09, $weatherDto->wind);
        $this->assertEquals('overcast clouds', $weatherDto->description);
        $this->assertEquals('Kharp', $weatherDto->name);
    }
}
