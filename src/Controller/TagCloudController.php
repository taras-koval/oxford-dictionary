<?php

namespace App\Controller;

use App\Repository\SearchesRepository;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;

class TagCloudController extends AbstractController
{
    private CacheInterface $cache;

    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Returns TagCloud render with cached Top Tags.
     *
     * @param SearchesRepository $repository
     * @return Response
     * @throws InvalidArgumentException
     */
    #[Route('/tag-cloud', name: 'tag_cloud')]
    public function getTopTagsPage(SearchesRepository $repository): Response
    {
        $topTags = $this->cache->get('topTags', fn() => $repository->getTopTags());

        return $this->render('tag_cloud.html.twig', [
            'topTags' => $topTags,
        ]);
    }
    
}
