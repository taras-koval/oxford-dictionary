<?php

namespace App\Service\OxfordDictionary\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GuzzleClient implements ClientInterface
{
    private Client $client;
    const BASE_URI = 'https://od-api.oxforddictionaries.com/api/v2/';
    
    public function __construct(string $appId, string $appKey)
    {
        $this->client = new Client([
            'base_uri' => self::BASE_URI,
            'headers' => [
                'Accept' => 'application/json',
                'app_id' => $appId,
                'app_key' => $appKey,
            ]
        ]);
    }
    
    /**
     * @throws GuzzleException
     */
    public function get(string $url)
    {
        return json_decode($this->client->get($url)->getBody()->getContents(), true);
    }
}
