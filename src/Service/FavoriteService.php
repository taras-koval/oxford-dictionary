<?php

namespace App\Service;

use App\Entity\FavoriteWord;
use App\Entity\Searches;
use App\Repository\FavoriteWordRepository;
use App\Repository\SearchesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class FavoriteService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private FavoriteWordRepository $wordRepository,
        private SearchesRepository $searchesRepository,
        private Security $security
    ) {
    }

    /**
     * Add a new word to database
     *
     * @param Searches $searches
     */
    public function addWord(Searches $searches)
    {
        $favoriteWord = $this->wordRepository->findByWord($searches);
        if ($favoriteWord == null) {
            $search = (new FavoriteWord())
                ->setWord($searches)
                ->setUser($this->security->getUser());
            $this->entityManager->persist($search);
            $this->entityManager->flush();
        }
    }

    /**
     * Remove word from favorite list
     *
     * @param Searches $searches
     */
    public function removeWord(Searches $searches)
    {
        $favoriteWord = $this->wordRepository->findByWord($searches);
        $this->entityManager->remove($favoriteWord);
        $this->entityManager->flush();
    }

    public function isFavorite(string $word): bool
    {
        $searches = $this->searchesRepository->findTag($word);

        $favoriteWord = $this->wordRepository->findOneBy([
            'word' => $searches,
            'user' => $this->security->getUser()
        ]);

        return $favoriteWord !== null;
    }
}
