<?php

namespace App\Controller;

use App\Entity\Searches;
use App\Repository\SearchesRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Exception\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagCloudController extends AbstractController
{

    /**
     * Returns TagCloud render with cached Top Tags.
     *
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/TagCloud', name: 'TagCloud')]
    public function getTop50TagsPage(EntityManagerInterface $entityManager): Response
    {
        $response = $this->render('TagCloud.html.twig',['topTags'=>(array) $entityManager->getRepository(Searches::class)->createQueryBuilder('p')
            ->select('p.word', 'p.cnt')
            ->orderBy('p.cnt', 'DESC')
            ->setMaxResults(20)
            ->getQuery()
            ->getResult()]);

        $response->setPublic();
        $response->setMaxAge(3600);     //cache lives for 1 hour

        return $response;
    }
}
