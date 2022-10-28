<?php

namespace App\Service;

use App\Entity\ODResponseCache;
use App\Repository\ODResponseCacheRepository;
use App\Service\OxfordDictionary\Client\ClientInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;

#[AsDecorator(decorates: ClientInterface::class)]
class ODResponseCacheService implements ClientInterface
{
    private ClientInterface $client;
    private EntityManagerInterface $entityManager;
    private ODResponseCacheRepository $cacheRepository;
    
    public function __construct(
        ClientInterface $client,
        EntityManagerInterface $entityManager,
        ODResponseCacheRepository $cacheRepository,
    ) {
        $this->client = $client;
        $this->entityManager = $entityManager;
        $this->cacheRepository = $cacheRepository;
    }
    
    public function get(string $url): ?array
    {
        $cache = $this->cacheRepository->findOneBy(['query' => $url]);
        
        if (!isset($cache)) {
            $cache = new ODResponseCache();
            $cache->setQuery($url);
            try {
                $cache->setData($this->client->get($url));
            } finally {
                $this->entityManager->persist($cache);
                $this->entityManager->flush();
            }
        }
        
        return $cache->getData();
    }
}
