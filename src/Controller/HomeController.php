<?php

namespace App\Controller;

use App\Repository\SearchesRepository;
use Psr\Cache\CacheItemInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;

class HomeController extends AbstractController
{
    public function __construct(private CacheInterface $cache)
    {
    }

    /**
     * Just to render something at the main page.
     *
     * @param SearchesRepository $repository
     * @return Response
     * @throws \Psr\Cache\InvalidArgumentException
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
