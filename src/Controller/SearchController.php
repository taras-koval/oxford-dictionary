<?php

namespace App\Controller;

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
    public function search(SearchesService $searchService, OxfordDictionary $dictionary, Request $request): Response
    {
        $word = $request->get('q');
        $entries = [];
        
        if (!empty($word)) {
            $word = strtolower($word);
            
            $lemma = $dictionary->lemma($word);
            
            if ($lemma) {
                $word = $lemma->getInflectionOf();
                $entries = $dictionary->entries($word);
            }
            
            $searchService->addSearch($word);
        }

        return $this->render('search.html.twig', [
            'word' => $word,
            'entries' => $entries
        ]);
    }
}
