<?php

namespace App\Service\OxfordDictionary;

use App\Service\OxfordDictionary\Api\EntriesBuilder;
use App\Service\OxfordDictionary\Api\Entry;
use App\Service\OxfordDictionary\Client\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

class OxfordDictionary
{
    private ClientInterface $client;
    private EntriesBuilder $entriesBuilder;
    
    public function __construct(ClientInterface $client, EntriesBuilder $entriesBuilder)
    {
        $this->client = $client;
        $this->entriesBuilder = $entriesBuilder;
    }
    
    /**
     * @throws OxfordDictionaryException
     * @return Entry[]
     */
    public function entries(string $word, string $lang = 'en-us'): array
    {
        try {
            $response = $this->client->get("entries/$lang/$word?fields=definitions%2Cpronunciations&strictMatch=false");
            return $this->entriesBuilder->build($response);
        } catch (GuzzleException $e) {
            if ($e->getCode() == '404') {
                return [];
            }
            
            throw new OxfordDictionaryException('Something went wrong');
        }
    }
}
