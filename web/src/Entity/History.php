<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\HistoryRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: HistoryRepository::class)]
#[ORM\Table(name: 'history')]
class History
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 2)]
    #[Assert\NotBlank]
    private string $temperature;

    #[ORM\Column(type: Types::INTEGER)]
    #[Assert\NotBlank]
    private int $cloudiness;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 2)]
    #[Assert\NotBlank]
    private string $wind;

    #[ORM\Column(type: Types::STRING, length: 128)]
    #[Assert\NotBlank]
    private string $description;

    #[ORM\Column(type: Types::DECIMAL, precision: 20, scale: 16)]
    #[Assert\NotBlank]
    private string $lat;

    #[ORM\Column(type: Types::DECIMAL, precision: 20, scale: 16)]
    #[Assert\NotBlank]
    private string $lng;

    #[ORM\Column(type: Types::STRING, length: 128)]
    #[Assert\NotBlank]
    private string $city;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Assert\NotBlank]
    private DateTimeImmutable $dateTime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTemperature(): string
    {
        return $this->temperature;
    }

    public function setTemperature(string $temperature): static
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getCloudiness(): int
    {
        return $this->cloudiness;
    }

    public function setCloudiness(int $cloudiness): static
    {
        $this->cloudiness = $cloudiness;

        return $this;
    }

    public function getWind(): string
    {
        return $this->wind;
    }

    public function setWind(string $wind): static
    {
        $this->wind = $wind;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLat(): string
    {
        return $this->lat;
    }

    public function setLat(string $lat): static
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): string
    {
        return $this->lng;
    }

    public function setLng(string $lng): static
    {
        $this->lng = $lng;

        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getDateTime(): DateTimeImmutable
    {
        return $this->dateTime;
    }

    public function setDateTime(DateTimeImmutable $dateTime): static
    {
        $this->dateTime = $dateTime;

        return $this;
    }
}
