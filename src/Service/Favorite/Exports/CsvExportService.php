<?php

namespace App\Service\Favorite\Exports;

use League\Csv\CannotInsertRecord;
use League\Csv\Writer;
use Symfony\Component\Security\Core\Security;

class CsvExportService implements FavoriteExportInterface
{
    private Writer $writer;
    private string $filePath;

    public function __construct(private string $url, Security $security)
    {
        $userName = strtolower($security->getUser()->getName());
        $this->filePath = '../var/exports/' . $userName . '_' . time() . '.csv';
        $this->writer = Writer::createFromPath($this->filePath, 'w+');
    }

    /**
     * @param array $words
     * @return string
     * @throws CannotInsertRecord
     */
    public function export(array $words): string
    {
        $this->writer->setDelimiter(';');

        $onlyNames = array_column($words, 'word');
        $data = [];
        foreach ($onlyNames as $name) {
            $data[] = [$name, $this->url . '/search?q=' . $name];
        }

        $this->writer->insertOne(['Word', 'Link']);
        $this->writer->insertAll($data);

        return $this->filePath;
    }
}
