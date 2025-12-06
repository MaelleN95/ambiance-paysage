<?php

namespace App\Repository;

use App\Entity\Service;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Service>
 */
class ServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Service::class);
    }

    public function findPrioritized(): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.prioritized = true')
            ->orderBy('s.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findNonPrioritized(): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.prioritized = false')
            ->orderBy('s.name', 'ASC')
            ->getQuery()
            ->getResult();
    }


}
