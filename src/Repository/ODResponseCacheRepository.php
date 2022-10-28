<?php

namespace App\Repository;

use App\Entity\ODResponseCache;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ODResponseCache>
 *
 * @method ODResponseCache|null find($id, $lockMode = null, $lockVersion = null)
 * @method ODResponseCache|null findOneBy(array $criteria, array $orderBy = null)
 * @method ODResponseCache[]    findAll()
 * @method ODResponseCache[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ODResponseCacheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ODResponseCache::class);
    }
    
}
