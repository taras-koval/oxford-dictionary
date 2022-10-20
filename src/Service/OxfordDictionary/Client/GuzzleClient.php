<?php

namespace App\Service\OxfordDictionary\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GuzzleClient implements ClientInterface
{
    private Client $client;
    
    public function __construct(string $endpoint, string $appId, string $appKey)
    {
        $this->client = new Client([
            'base_uri' => $endpoint,
            'headers' => [
                'Accept' => 'application/json',
                'app_id' => $appId,
                'app_key' => $appKey,
            ]
        ]);
    }
    
    /**
     * @throws ClientException
     */
    public function get(string $url)
    {
        try {
            return json_decode($this->client->get($url)->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new ClientException($e->getMessage(), $e->getCode());
        }
    }
}
