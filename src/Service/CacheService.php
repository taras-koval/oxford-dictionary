<?php

namespace App\Service;

use App\Entity\Cache;
use App\Repository\CacheRepository;
use App\Service\OxfordDictionary\Client\ClientInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;

#[AsDecorator(decorates: ClientInterface::class)]
class CacheService implements ClientInterface
{
    private ClientInterface $client;
    private EntityManagerInterface $entityManager;
    private CacheRepository $cacheRepository;
    
    public function __construct(
        ClientInterface $client,
        EntityManagerInterface $entityManager,
        CacheRepository $cacheRepository,
    ) {
        $this->client = $client;
        $this->entityManager = $entityManager;
        $this->cacheRepository = $cacheRepository;
    }
    
    public function get(string $url): ?array
    {
        $cache = $this->cacheRepository->findOneBy(['query' => $url]);
        
        if (!isset($cache)) {
            $cache = new Cache();
            try {
                $cache->setQuery($url);
                $cache->setData($this->client->get($url));
            } finally {
                $this->entityManager->persist($cache);
                $this->entityManager->flush();
            }
        }
        
        return $cache->getData();
    }
}
