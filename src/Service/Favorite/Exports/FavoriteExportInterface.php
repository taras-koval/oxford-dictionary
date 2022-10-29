<?php

namespace App\Service\Favorite\Exports;

interface FavoriteExportInterface
{
    public function export(array $words);
}
