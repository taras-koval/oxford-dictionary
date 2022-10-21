<?php

namespace App\Repository;

use App\Entity\Searches;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * @extends ServiceEntityRepository<Searches>
 *
 * @method Searches|null find($id, $lockMode = null, $lockVersion = null)
 * @method Searches|null findOneBy(array $criteria, array $orderBy = null)
 * @method Searches[]    findAll()
 * @method Searches[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SearchesRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Searches::class);
    }

    /**
     * @return Searches[] Returns an array of Searches objects
     */
    public function getTopTags(): array
    {
        return (array)$this
                    ->createQueryBuilder('p')
                    ->select('p.word', 'p.cnt')
                    ->orderBy('p.cnt', 'DESC')
                    ->setMaxResults(20)
                    ->getQuery()
                    ->getResult();
    }
}
