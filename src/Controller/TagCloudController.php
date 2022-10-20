<?php

namespace App\Controller;

use App\Entity\Searches;
use App\Repository\SearchesRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use http\Exception\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagCloudController extends AbstractController
{

    public function getTopTags(int $qty = 50, SearchesRepository $searches){
        if ($qty<0) throw new InvalidArgumentException('Bad quantity argument while calling getTopTags function. Argument should be higher than 0.');

        $query = $searches->createQueryBuilder()
                    ->select('words', 'cnt')
                    ->orderBy('cnt', 'DESC')
                    ->setMaxResults($qty);
        return $query->getQuery()->getResult();
    }

    /**
     * Just to render something at the main page.
     *
     * @return Response
     */
    #[Route('/TagCloud', name: 'TagCloud')]
    public function getTop50TagsPage(EntityManagerInterface $entityManager): Response
    {
        $repo = $entityManager->getRepository(Searches::class);
        $topTags = $repo->createQueryBuilder('p')
            ->select('p.word', 'p.cnt')
                ->orderBy('p.cnt', 'DESC')
                ->setMaxResults(20)
        ->getQuery()->getResult();
        //dd($topTags);
        return $this->render(
            'TagCloud.html.twig',['topTags'=>(array) $topTags]
        );
    }
}
