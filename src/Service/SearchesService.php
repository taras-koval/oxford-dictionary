<?php

namespace App\Service;

use App\Repository\SearchesRepository;

class SearchesService
{
    public function __construct(private SearchesRepository $repository)
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
            $this->repository->createTag($word);
        } else {
            $this->repository->incrementCount($search);
        }
    }
}
