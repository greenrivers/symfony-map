<?php

declare(strict_types=1);

namespace App\Tests\Integration\Repository;

use App\DataFixtures\HistoryFixtures;
use App\Entity\History;
use App\Repository\HistoryRepository;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HistoryRepositoryTest extends KernelTestCase
{
    private HistoryRepository $historyRepository;

    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $container = static::getContainer();
        /** @var Registry $doctrine */
        $doctrine = $container->get('doctrine');

        $this->historyRepository = $container->get(HistoryRepository::class);
        $this->entityManager = $doctrine->getManager();

        $schemaTool = new SchemaTool($this->entityManager);
        $metadata = $this->entityManager->getMetadataFactory()
            ->getAllMetadata();

        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);
    }

    /**
     * @covers HistoryRepository::findAllSortByDateTime
     */
    public function testFindAllSortByDateTime(): void
    {
        $fixture = new HistoryFixtures();
        $fixture->load($this->entityManager);

        /** @var History[] $histories */
        $histories = $this->historyRepository->findAllSortByDateTime();

        $this->assertCount(3, $histories);

        $this->assertInstanceOf(History::class, $histories[0]);
        $this->assertEquals('6', $histories[0]->getTemperature());
        $this->assertEquals(100, $histories[0]->getCloudiness());
        $this->assertEquals('10.96', $histories[0]->getWind());
        $this->assertEquals('overcast clouds', $histories[0]->getDescription());
        $this->assertEquals('59.87854780637643', $histories[0]->getLat());
        $this->assertEquals('2.542888479232772', $histories[0]->getLng());
        $this->assertEquals('Utsira', $histories[0]->getCity());
        $this->assertEquals(new DateTimeImmutable('15.10.2023, 19:15:58'), $histories[0]->getDateTime());

        $this->assertInstanceOf(History::class, $histories[1]);
        $this->assertEquals('14.44', $histories[1]->getTemperature());
        $this->assertEquals(80, $histories[1]->getCloudiness());
        $this->assertEquals('3.89', $histories[1]->getWind());
        $this->assertEquals('clear sky', $histories[1]->getDescription());
        $this->assertEquals('51.07809607740873', $histories[1]->getLat());
        $this->assertEquals('40.38858945846556', $histories[1]->getLng());
        $this->assertEquals('Khrenovoye', $histories[1]->getCity());
        $this->assertEquals(new DateTimeImmutable('26.09.2023, 19:18:35'), $histories[1]->getDateTime());

        $this->assertInstanceOf(History::class, $histories[2]);
        $this->assertEquals('7.1', $histories[2]->getTemperature());
        $this->assertEquals(0, $histories[2]->getCloudiness());
        $this->assertEquals('3.09', $histories[2]->getWind());
        $this->assertEquals('clear sky', $histories[2]->getDescription());
        $this->assertEquals('49.380335780949686', $histories[2]->getLat());
        $this->assertEquals('10.787022666931136', $histories[2]->getLng());
        $this->assertEquals('Utsira', $histories[2]->getCity());
        $this->assertEquals(new DateTimeImmutable('12.09.2023, 12:10:25'), $histories[2]->getDateTime());
    }

    /**
     * @covers HistoryRepository::findStats
     */
    public function testFindStats(): void
    {
        $fixture = new HistoryFixtures();
        $fixture->load($this->entityManager);

        $stats = $this->historyRepository->findStats();

        $this->assertCount(4, $stats);
        $this->assertEquals('6.00', $stats['minTemperature']);
        $this->assertEquals('14.44', $stats['maxTemperature']);
        $this->assertEquals('9.18', round((float)$stats['avgTemperature'], 2));
        $this->assertEquals('Utsira', $stats['mostFrequentCity']);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
    }
}
