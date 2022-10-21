<?php

namespace App\Controller;

use App\Repository\SearchesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * Just to render something at the main page.
     *
     * @param SearchesRepository $repository
     * @return Response
     */
    #[Route('/', name: 'index')]
    public function index(SearchesRepository $repository): Response
    {
        $topTags = $repository->getTopTags();

        return $this->render('index.html.twig', [
            'topTags' => $topTags
        ]);
    }
}
