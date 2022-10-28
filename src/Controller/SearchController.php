<?php

namespace App\Controller;

use App\Service\FavoriteService;
use App\Service\OxfordDictionary\OxfordDictionary;
use App\Service\OxfordDictionary\OxfordDictionaryException;
use App\Service\SearchesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * Search for results and render page
     *
     * @throws OxfordDictionaryException
     */
    #[Route('/search', name: 'search')]
    public function search(
        SearchesService $searchService,
        OxfordDictionary $dictionary,
        FavoriteService $favoriteService,
        Request $request
    ): Response {
        $word = $request->get('q');
        $entries = [];
        $isFavorite = null;

        if (! empty($word)) {
            $word = strtolower($word);

            $lemma = $dictionary->lemma($word);
            if ($lemma) {
                $word = $lemma->getInflectionOf();
            }

            $searchService->addSearch($word);

            $entries = $dictionary->entries($word);
        }

        if (! empty($entries)) {
            $isFavorite = $favoriteService->isFavorite($word);
        }

        return $this->render('search.html.twig', [
            'word' => $word,
            'isFavorite' => $isFavorite,
            'entries' => $entries
        ]);
    }
}
