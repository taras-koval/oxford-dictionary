<?php

namespace App\Service\OxfordDictionary;

use App\Service\OxfordDictionary\Api\EntriesBuilder;
use App\Service\OxfordDictionary\Api\Entry;
use App\Service\OxfordDictionary\Client\ClientException;
use App\Service\OxfordDictionary\Client\ClientInterface;

class OxfordDictionary
{
    private ClientInterface $client;
    
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }
    
    /**
     * @throws OxfordDictionaryException
     * @return Entry[]
     */
    public function entries(string $word, string $lang = 'en-us'): array
    {
        try {
            $response = $this->client->get("entries/$lang/$word?fields=definitions%2Cpronunciations&strictMatch=false");
            return (new EntriesBuilder($response))->build();
        } catch (ClientException $e) {
            if ($e->getCode() == '404') {
                return [];
            }
            
            throw new OxfordDictionaryException('Something went wrong');
        }
    }
}
