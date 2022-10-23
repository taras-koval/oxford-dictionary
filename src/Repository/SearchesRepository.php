<?php

namespace App\Repository;

use App\Entity\Searches;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

    /**
     * Find word in database by name
     *
     * @param string $word
     * @return Searches|null
     */
    public function findTag(string $word): ?Searches
    {
        return $this->findOneBy(['word' => $word]);
    }

    /**
     * Add a new word to database
     *
     * @param string $word
     */
    public function createTag(string $word)
    {
        $entityManager = $this->getEntityManager();
        $search = new Searches();
        $search->setWord($word);
        $search->setCnt(1);
        $entityManager->persist($search);
        $entityManager->flush();
    }

    /**
     * Increment count of word
     *
     * @param Searches $search
     */
    public function incrementCount(Searches $search)
    {
        $entityManager = $this->getEntityManager();
        $search->incrementCnt();
        $entityManager->flush();
    }
}
