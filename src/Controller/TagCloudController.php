<?php

namespace App\Controller;

use App\Repository\SearchesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class TagCloudController extends AbstractController
{

    private CacheInterface $myCachePool;

    public function __construct(CacheInterface $topTagsCache)
    {
        $this->myCachePool = $topTagsCache;
    }

    /**
     * Returns TagCloud render with cached Top Tags.
     *
     * @param SearchesRepository $repository
     * @return Response
     * @throws InvalidArgumentException
     */
    #[Route('/tag-cloud', name: 'tag_cloud')]
    public function getTopTagsPage(
        SearchesRepository $repository
    ): Response {
        $topTags = $this->myCachePool->get(
            'topTags',
            function () use ($repository) {
                return $repository->getTopTags();
            }
        );

        return $this->render(
            'tag_cloud.php.twig',
            [
                'topTags' => $topTags,
            ]
        );
    }

}
