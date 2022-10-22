<?php

namespace App\Controller;

use App\Service\OxfordDictionary\OxfordDictionary;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/{word}', name: 'index')]
    public function index(string $word, OxfordDictionary $dictionary): Response
    {
        // $entries = $dictionary->entries($word);
        
        return $this->render('index.php.twig');
    }
}
