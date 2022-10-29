<?php

namespace App\Controller;

use App\Repository\SearchesRepository;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;

class HomeController extends AbstractController
{
    private CacheInterface $cache;
    
    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Render index page with tag cloud
     *
     * @param SearchesRepository $repository
     * @return Response
     * @throws InvalidArgumentException
     */
    #[Route('/', name: 'index')]
    public function index(SearchesRepository $repository): Response
    {
        $topTags = $this->cache->get('topTags', fn() => $repository->getTopTags());

        return $this->render('index.html.twig', [
            'topTags' => $topTags
        ]);
    }
}
