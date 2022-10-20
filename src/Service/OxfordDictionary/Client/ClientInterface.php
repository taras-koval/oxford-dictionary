<?php

namespace App\Service\OxfordDictionary\Client;

interface ClientInterface
{
    /**
     * @throws ClientException
     */
    public function get(string $url);
}
