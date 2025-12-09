<?php

namespace App\Repository;

use App\Entity\Photo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Photo>
 */
class PhotoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Photo::class);
    }

    /**
     * Récupère les photos par catégorie.
     *
     * @param string $category 'work_in_progress' ou 'finished'
     * @return Photo[]
     */
    public function findByCategory(string $category): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.category = :cat')
            ->setParameter('cat', $category)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }


    public function findByCategoryLast(string $category, int $limit = 4): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.category = :cat')
            ->setParameter('cat', $category)
            ->orderBy('p.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findByCategoryOrdered(string $category): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.category = :c')
            ->setParameter('c', $category)
            ->orderBy('p.updatedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
