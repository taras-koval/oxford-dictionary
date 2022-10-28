<?php

namespace App\Controller;

use App\Repository\SearchesRepository;
use App\Service\OxfordDictionary\OxfordDictionary;
use App\Service\OxfordDictionary\OxfordDictionaryException;
use App\Service\SearchesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * Returns array of possible words with same beginning
     *
     * @param Request $request
     * @param SearchesRepository $search
     * @return JsonResponse
     */
    #[Route('/quick-search', name: 'quick_search')]
    public function quickSearch(Request $request, SearchesRepository $search): JsonResponse
    {
        $wordBegin = $request->query->get('wordBegin');
        if (strlen($wordBegin) > 2) {

            return new JsonResponse([
                'status'    => 1,
                'matches'   => $search->getFastSearchMatchWords($wordBegin)
            ]);
        }

        return new JsonResponse([
            'status' => 0,
            'message'=> 'At least 3 symbols required for search initiation.'
        ]);
    }

    /**
     * Search for results and render page
     *
     * @throws OxfordDictionaryException
     */
    #[Route('/search', name: 'search')]
    public function search(SearchesService $searchService, OxfordDictionary $dictionary, Request $request): Response
    {
        $word = $request->get('q');
        $entries = [];

        if (!empty($word)) {
            $word = strtolower($word);

            $lemma = $dictionary->lemma($word);
            if ($lemma) {
                $word = $lemma->getInflectionOf();
            }

            $searchService->addSearch($word);

            $entries = $dictionary->entries($word);
        }

        return $this->render('search.html.twig', [
            'word' => $word,
            'entries' => $entries
        ]);
    }
}
