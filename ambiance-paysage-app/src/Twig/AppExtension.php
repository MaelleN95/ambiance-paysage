<?php

namespace App\Twig;

use App\Repository\ScheduleRepository;
use App\Repository\SocialNetworkRepository;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class AppExtension extends AbstractExtension implements GlobalsInterface
{
    public function __construct(
        private SocialNetworkRepository $socialNetworkRepository, 
        private ScheduleRepository $scheduleRepository
        ) {}

    public function getGlobals(): array
    {
        return [
            'socialNetworks' => $this->socialNetworkRepository->findAll(),
            'schedules' => $this->scheduleRepository->findAllOrderedByDay(),
        ];
    }
}
