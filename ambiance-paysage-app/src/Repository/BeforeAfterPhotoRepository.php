<?php

namespace App\Repository;

use App\Entity\BeforeAfterPhoto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BeforeAfterPhoto>
 */
class BeforeAfterPhotoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BeforeAfterPhoto::class);
    }
}
