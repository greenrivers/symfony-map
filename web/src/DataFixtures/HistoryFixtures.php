<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\History;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HistoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $historiesData = [
            [
                'temperature' => '6',
                'cloudiness' => 100,
                'wind' => '10.96',
                'description' => 'overcast clouds',
                'lat' => '59.87854780637643',
                'lng' => '2.542888479232772',
                'city' => 'Utsira',
                'dateTime' => new DateTimeImmutable('15.10.2023, 19:15:58')
            ],
            [
                'temperature' => '14.44',
                'cloudiness' => 80,
                'wind' => '3.89',
                'description' => 'clear sky',
                'lat' => '51.07809607740873',
                'lng' => '40.38858945846556',
                'city' => 'Khrenovoye',
                'dateTime' => new DateTimeImmutable('26.09.2023, 19:18:35')
            ],
            [
                'temperature' => '7.1',
                'cloudiness' => 0,
                'wind' => '3.09',
                'description' => 'clear sky',
                'lat' => '49.380335780949686',
                'lng' => '10.787022666931136',
                'city' => 'Utsira',
                'dateTime' => new DateTimeImmutable('12.09.2023, 12:10:25')
            ]
        ];

        foreach ($historiesData as $historyData) {
            $history = new History();
            $history->setTemperature($historyData['temperature'])
                ->setCloudiness($historyData['cloudiness'])
                ->setWind($historyData['wind'])
                ->setDescription($historyData['description'])
                ->setLat($historyData['lat'])
                ->setLng($historyData['lng'])
                ->setCity($historyData['city'])
                ->setDateTime($historyData['dateTime']);

            $manager->persist($history);
        }

        $manager->flush();
    }
}
