<?php

namespace App\Controller;

use App\Repository\SearchesRepository;
use Psr\Cache\CacheItemInterface;
use App\Service\OxfordDictionary\OxfordDictionary;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;

class HomeController extends AbstractController
{
    public function __construct(private CacheInterface $cache)
    {
    }

    #[Route('/', name: 'index')]
    public function index(OxfordDictionary $dictionary, SearchesRepository $repository): Response
    {
        $topTags = $this->cache->get('topTags', fn() => $repository->getTopTags());
    
        // $entries = $dictionary->entries($word);
    
        return $this->render('index.html.twig', [
            'topTags' => $topTags
        ]);
    }
}
