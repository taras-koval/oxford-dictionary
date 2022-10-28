<?php

namespace App\Repository;

use App\Entity\FavoriteWord;
use App\Entity\Searches;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * @extends ServiceEntityRepository<FavoriteWord>
 *
 * @method FavoriteWord|null find($id, $lockMode = null, $lockVersion = null)
 * @method FavoriteWord|null findOneBy(array $criteria, array $orderBy = null)
 * @method FavoriteWord[]    findAll()
 * @method FavoriteWord[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavoriteWordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private Security $security)
    {
        parent::__construct($registry, FavoriteWord::class);
    }

    public function findByWord(Searches $searches): ?FavoriteWord
    {
        return $this->findOneBy(['word' => $searches]);
    }

    /**
     * @return FavoriteWord[] Returns an array of FavoriteWord objects
     */
    public function getFavoriteWords(): array
    {
        $user = $this->security->getUser();

        return $this
            ->createQueryBuilder('f')
            ->select('f', 'w')
            ->join('f.word', 'w')
            ->where('f.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getArrayResult();
    }
}
