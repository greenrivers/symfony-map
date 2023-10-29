<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\HistoryDto;
use App\Dto\StatsDto;
use App\Entity\History;
use App\Repository\HistoryRepository;
use App\Serializer\DtoSerializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class HistoryService
{
    public function __construct(
        private readonly HistoryRepository $historyRepository,
        private readonly DtoSerializer     $dtoSerializer
    )
    {
    }

    public function saveHistory(array $data): void
    {
        $historyDto = $this->dtoSerializer->denormalize($data, HistoryDto::class);

        $history = $this->createHistory($historyDto);
        $this->historyRepository->add($history, true);
    }

    public function getHistories(): array
    {
        $histories = $this->historyRepository->findAllSortByDateTime();

        $jsonHistories = $this->dtoSerializer->serialize($histories, JsonEncoder::FORMAT);
        return $this->dtoSerializer->deserialize($jsonHistories, 'App\Dto\HistoryDto[]', JsonEncoder::FORMAT);
    }

    public function getStats(): ?StatsDto
    {
        $stats = $this->historyRepository->findStats();
        $statsEmpty = empty(array_filter($stats, static fn ($item) => !is_null($item)));

        return !$statsEmpty ? $this->dtoSerializer->denormalize($stats, StatsDto::class) : null;
    }

    private function createHistory(HistoryDto $historyDto): History
    {
        $history = new History();
        $history->setTemperature($historyDto->temperature)
            ->setCloudiness($historyDto->cloudiness)
            ->setWind($historyDto->wind)
            ->setDescription($historyDto->description)
            ->setLat($historyDto->lat)
            ->setLng($historyDto->lng)
            ->setCity($historyDto->city)
            ->setDateTime($historyDto->dateTime);

        return $history;
    }
}
