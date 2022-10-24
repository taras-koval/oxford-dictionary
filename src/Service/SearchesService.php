<?php

namespace App\Service;

use App\Entity\Searches;
use App\Repository\SearchesRepository;
use Doctrine\ORM\EntityManagerInterface;

class SearchesService
{
    public function __construct(private EntityManagerInterface $entityManager, private SearchesRepository $repository)
    {
    }

    /**
     * Add new or increment count of existing word
     */
    public function addSearch(string $word)
    {
        $word = ucfirst(strtolower($word));

        $search = $this->repository->findTag($word);
        if ($search == null) {
            $this->createTag($word);
        } else {
            $this->incrementCount($search);
        }
    }

    /**
     * Add a new word to database
     *
     * @param string $word
     */
    public function createTag(string $word)
    {
        $search = (new Searches())
            ->setWord($word)
            ->setCnt(1);
        $this->entityManager->persist($search);
        $this->entityManager->flush();
    }

    /**
     * Increment count of word
     *
     * @param Searches $search
     */
    public function incrementCount(Searches $search)
    {
        $search->incrementCnt();
        $this->entityManager->flush();
    }
}
