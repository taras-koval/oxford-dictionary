<?php

namespace App\Controller;

use App\Repository\SearchesRepository;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagCloudController extends AbstractController
{
    /**
     * Returns TagCloud render with cached Top Tags.
     *
     * @param SearchesRepository $repository
     * @return Response
     * @throws InvalidArgumentException
     */
    #[Route('/tag_cloud', name: 'tag_cloud')]
    public function getTopTagsPage(SearchesRepository $repository): Response
    {
        $topTags = $repository->getTopTags();

        return $this->render('tag_cloud.php.twig', [
            'topTags' => $topTags,
        ]);
    }
}
