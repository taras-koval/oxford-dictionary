<?php

namespace App\Controller;

use App\Service\OxfordDictionary\OxfordDictionary;
use App\Service\OxfordDictionary\OxfordDictionaryException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @throws OxfordDictionaryException
     */
    #[Route('/', name: 'index')]
    public function index(OxfordDictionary $dictionary): Response
    {
        $entries = $dictionary->entries('apple');
        
        foreach ($entries as $entry) {
            dump($entry->toArray());
        }
        
        return $this->render('index.php.twig');
    }
}
