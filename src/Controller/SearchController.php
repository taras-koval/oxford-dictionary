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
     * @param SearchesService $service
     * @param OxfordDictionary $dictionary
     * @param Request $request
     * @return Response
     * @throws OxfordDictionaryException
     */
    #[Route('/search', name: 'search')]
    public function search(SearchesService $service, OxfordDictionary $dictionary, Request $request): Response
    {
        $entries = [];
        $word = $request->get('q');
        if ($word) {
            $entries = $dictionary->entries($word);
            if (! empty($entries)) {
                $service->addSearch($word);
            }
        }

        return $this->render('search.html.twig', [
            'word' => $word,
            'entries' => $entries
        ]);
    }
}
