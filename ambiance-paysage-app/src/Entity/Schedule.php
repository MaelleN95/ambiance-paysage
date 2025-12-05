<?php

namespace App\Entity;

use App\Repository\ScheduleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScheduleRepository::class)]
class Schedule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $dayName = null;

    #[ORM\Column(length: 255)]
    private ?string $mode = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTime $morningStart = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTime $morningEnd = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $afternoonStart = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $afternoonEnd = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDayName(): ?string
    {
        return $this->dayName;
    }

    public function setDayName(string $dayName): static
    {
        $this->dayName = $dayName;

        return $this;
    }

    public function getMode(): ?string
    {
        return $this->mode;
    }

    public function setMode(string $mode): static
    {
        $this->mode = $mode;

        return $this;
    }

    public function getMorningStart(): ?\DateTime
    {
        return $this->morningStart;
    }

    public function setMorningStart(?\DateTime $morningStart): static
    {
        $this->morningStart = $morningStart;

        return $this;
    }

    public function getMorningEnd(): ?\DateTime
    {
        return $this->morningEnd;
    }

    public function setMorningEnd(?\DateTime $morningEnd): static
    {
        $this->morningEnd = $morningEnd;

        return $this;
    }

    public function getAfternoonStart(): ?string
    {
        return $this->afternoonStart;
    }

    public function setAfternoonStart(?string $afternoonStart): static
    {
        $this->afternoonStart = $afternoonStart;

        return $this;
    }

    public function getAfternoonEnd(): ?string
    {
        return $this->afternoonEnd;
    }

    public function setAfternoonEnd(?string $afternoonEnd): static
    {
        $this->afternoonEnd = $afternoonEnd;

        return $this;
    }
}
