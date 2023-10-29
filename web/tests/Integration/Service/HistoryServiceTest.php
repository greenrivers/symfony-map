<?php

declare(strict_types=1);

namespace App\Tests\Integration\Service;

use App\DataFixtures\HistoryFixtures;
use App\Dto\HistoryDto;
use App\Dto\StatsDto;
use App\Entity\History;
use App\Service\HistoryService;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HistoryServiceTest extends KernelTestCase
{
    private HistoryService $historyService;

    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $container = static::getContainer();
        /** @var Registry $doctrine */
        $doctrine = $container->get('doctrine');

        $this->historyService = $container->get(HistoryService::class);
        $this->entityManager = $doctrine->getManager();

        $schemaTool = new SchemaTool($this->entityManager);
        $metadata = $this->entityManager->getMetadataFactory()
            ->getAllMetadata();

        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);
    }

    /**
     * @covers HistoryService::saveHistory
     */
    public function testSaveHistory(): void
    {
        $data = [
            'temperature' => '15.00',
            'cloudiness' => 80,
            'wind' => '3.60',
            'description' => 'overcast clouds',
            'lat' => '38.5246734836877140',
            'lng' => '57.8116359868613260',
            'city' => 'London',
            'dateTime' => '30.08.2023, 18:30:45'
        ];

        $this->historyService->saveHistory($data);

        $history = $this->entityManager->getRepository(History::class)
            ->findOneBy(['dateTime' => new DateTimeImmutable('30.08.2023, 18:30:45')]);

        $this->assertEquals('15.00', $history->getTemperature());
        $this->assertEquals(80, $history->getCloudiness());
        $this->assertEquals('3.60', $history->getWind());
        $this->assertEquals('overcast clouds', $history->getDescription());
        $this->assertEquals('38.5246734836877140', $history->getLat());
        $this->assertEquals('57.8116359868613260', $history->getLng());
        $this->assertEquals('London', $history->getCity());
        $this->assertEquals(new DateTimeImmutable('30.08.2023, 18:30:45'), $history->getDateTime());
    }

    /**
     * @covers HistoryService::getHistories
     */
    public function testGetHistories(): void
    {
        $fixture = new HistoryFixtures();
        $fixture->load($this->entityManager);

        /** @var HistoryDto[] $histories */
        $histories = $this->historyService->getHistories();

        $this->assertCount(3, $histories);

        $this->assertInstanceOf(HistoryDto::class, $histories[0]);
        $this->assertEquals('6', $histories[0]->temperature);
        $this->assertEquals(100, $histories[0]->cloudiness);
        $this->assertEquals('10.96', $histories[0]->wind);
        $this->assertEquals('overcast clouds', $histories[0]->description);
        $this->assertEquals('59.87854780637643', $histories[0]->lat);
        $this->assertEquals('2.542888479232772', $histories[0]->lng);
        $this->assertEquals('Utsira', $histories[0]->city);
        $this->assertEquals(new DateTimeImmutable('15.10.2023, 19:15:58'), $histories[0]->dateTime);

        $this->assertInstanceOf(HistoryDto::class, $histories[1]);
        $this->assertEquals('14.44', $histories[1]->temperature);
        $this->assertEquals(80, $histories[1]->cloudiness);
        $this->assertEquals('3.89', $histories[1]->wind);
        $this->assertEquals('clear sky', $histories[1]->description);
        $this->assertEquals('51.07809607740873', $histories[1]->lat);
        $this->assertEquals('40.38858945846556', $histories[1]->lng);
        $this->assertEquals('Khrenovoye', $histories[1]->city);
        $this->assertEquals(new DateTimeImmutable('26.09.2023, 19:18:35'), $histories[1]->dateTime);

        $this->assertInstanceOf(HistoryDto::class, $histories[2]);
        $this->assertEquals('7.1', $histories[2]->temperature);
        $this->assertEquals(0, $histories[2]->cloudiness);
        $this->assertEquals('3.09', $histories[2]->wind);
        $this->assertEquals('clear sky', $histories[2]->description);
        $this->assertEquals('49.380335780949686', $histories[2]->lat);
        $this->assertEquals('10.787022666931136', $histories[2]->lng);
        $this->assertEquals('Utsira', $histories[2]->city);
        $this->assertEquals(new DateTimeImmutable('12.09.2023, 12:10:25'), $histories[2]->dateTime);
    }

    /**
     * @covers HistoryService::getStats
     */
    public function testGetStats(): void
    {
        $fixture = new HistoryFixtures();
        $fixture->load($this->entityManager);

        $stats = $this->historyService->getStats();

        $this->assertInstanceOf(StatsDto::class, $stats);
        $this->assertEquals('6.00', $stats->minTemperature);
        $this->assertEquals('14.44', $stats->maxTemperature);
        $this->assertEquals('9.18', $stats->avgTemperature);
        $this->assertEquals('Utsira', $stats->mostFrequentCity);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
    }
}
