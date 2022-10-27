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
    #[Route('/quick_search', name: 'quick_search')]
    public function quickSearch(Request $request, SearchesRepository $search)
    {
        $wordBegin = $request->query->get('wordBegin');
        if(strlen($wordBegin)>2){
            return  new JsonResponse([
                'status'    => 1,
                'matches'   => array_column((array) $search->getFastSearchMatchWords($wordBegin), 'word')
            ]);
        }

        return new JsonResponse(['status'    => 0]);
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
