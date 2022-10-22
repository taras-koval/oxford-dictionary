<?php

namespace App\Service\OxfordDictionary\Client;

interface ClientInterface
{
    public function get(string $url);
}
