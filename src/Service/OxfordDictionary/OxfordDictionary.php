<?php

namespace App\Service\OxfordDictionary;

use App\Service\OxfordDictionary\Api\Builders\EntriesBuilder;
use App\Service\OxfordDictionary\Api\Builders\LemmasBuilder;
use App\Service\OxfordDictionary\Api\Entry;
use App\Service\OxfordDictionary\Api\Lemma;
use App\Service\OxfordDictionary\Client\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

class OxfordDictionary
{
    private ClientInterface $client;
    private EntriesBuilder $entriesBuilder;
    private LemmasBuilder $lemmasBuilder;
    
    public function __construct(
        ClientInterface $client,
        EntriesBuilder $entriesBuilder,
        LemmasBuilder $lemmasBuilder,
    ) {
        $this->client = $client;
        $this->entriesBuilder = $entriesBuilder;
        $this->lemmasBuilder = $lemmasBuilder;
    }
    
    /**
     * @param  string  $word
     * @param  string  $lang
     * @return Entry[]|null
     * @throws OxfordDictionaryException
     */
    public function entries(string $word, string $lang = 'en-us'): ?array
    {
        try {
            $response = $this->client->get("entries/$lang/$word?fields=definitions%2Cexamples%2Cpronunciations&strictMatch=false");
            return !empty($response) ? $this->entriesBuilder->build($response) : null;
        } catch (GuzzleException $e) {
            if ($e->getCode() == '404') {
                return null;
            }
            
            throw new OxfordDictionaryException($e->getMessage());
        }
    }
    
    /**
     * Lemma is a general term for any headword, phrase, or other form that can be looked up.
     * (e.g., swimming > swim, books > book)
     *
     * @param  string  $word
     * @param  string  $lang
     * @return Lemma|null
     * @throws OxfordDictionaryException
     */
    public function lemma(string $word, string $lang = 'en'): ?Lemma
    {
        try {
            $response = $this->client->get("lemmas/$lang/$word");
            return !empty($response) ? $this->lemmasBuilder->build($response) : null;
        } catch (GuzzleException $e) {
            if ($e->getCode() == '404') {
                return null;
            }
            
            throw new OxfordDictionaryException($e->getMessage());
        }
    }
}
