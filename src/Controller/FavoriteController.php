<?php

namespace App\Controller;

use App\Repository\FavoriteWordRepository;
use App\Repository\SearchesRepository;
use App\Service\Favorite\Exports\CsvExportService;
use App\Service\Favorite\FavoriteService;
use League\Csv\CannotInsertRecord;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoriteController extends AbstractController
{
    #[Route('/favorites', name: 'favorite_list', methods: ['GET'])]
    public function index(FavoriteWordRepository $repository): Response
    {
        $favoriteWords = $repository->getFavoriteWords();

        return $this->render('profile.html.twig', [
            'words' => $favoriteWords
        ]);
    }

    #[Route('/favorites', name: 'add_favorite', methods: ['POST'])]
    public function store(Request $request, SearchesRepository $repository, FavoriteService $service): Response
    {
        if (empty($request->get('word'))) {
            return new JsonResponse([
                'status' => 'false',
                'message' => 'Empty parameter "word"',
                'data' => []
            ], 422);
        }

        $word = $repository->findTag($request->get('word'));
        if ($word == null) {
            return new JsonResponse([
                'status' => 'false',
                'message' => 'Requested word does not exist',
                'data' => []
            ], 404);
        }

        $service->addWord($word);

        return new JsonResponse([
            'status' => 'true',
            'message' => 'A word successfully added to the list',
            'data' => []
        ]);
    }

    #[Route('/favorites/{word}', name: 'delete_favorite', methods: ['DELETE'])]
    public function remove(string $word, SearchesRepository $repository, FavoriteService $service): Response
    {
        $word = $repository->findTag($word);
        if ($word == null) {
            return new JsonResponse([
                'status' => 'false',
                'message' => 'Requested word does not exist',
                'data' => []
            ], 404);
        }

        $service->removeWord($word);

        return new JsonResponse([
            'status' => 'true',
            'message' => 'A word successfully remove from the list',
            'data' => []
        ]);
    }

    #[Route('/favorites/export-as-csv', name: 'export_csv', methods: ['GET'])]
    public function export(CsvExportService $exportService, FavoriteWordRepository $repository, Request $request): BinaryFileResponse|JsonResponse
    {
        $words = $repository->getFavoriteWords();
        if (empty($words)) {
            return new JsonResponse([
                'status' => 'false',
                'message' => 'You have no words in favorite list',
                'data' => []
            ], 422);
        }
        try {
            $file = $exportService->export($words);
        } catch (CannotInsertRecord $e) {
            return new JsonResponse([
                'status' => 'false',
                'message' => 'An error occurred during export',
                'data' => []
            ]);
        }

        $response = $this->file($file, 'favorites.csv');
        $response->headers->set('Content-type', 'application/csv');

        return $response;
    }
}

