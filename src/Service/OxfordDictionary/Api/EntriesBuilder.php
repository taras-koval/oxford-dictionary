<?php

namespace App\Service\OxfordDictionary\Api;

use Symfony\Component\PropertyAccess\PropertyAccess;

class EntriesBuilder
{
    /**
     * @return Entry[]
     */
    public function build(array $data) : array
    {
        $entries = [];
    
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        $results = $propertyAccessor->getValue($data, '[results]') ?? [];
        
        foreach ($results as $item) {
            $entries[] = $this->buildEntry($item);
        }
        
        return $entries;
    }
    
    private function buildEntry($entryData): Entry
    {
        $entry = new Entry();
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        
        foreach ($propertyAccessor->getValue($entryData, '[lexicalEntries]') ?? [] as $lexicalEntry) {
            foreach ($propertyAccessor->getValue($lexicalEntry, '[entries]') ?? [] as $item) {
                
                foreach ($propertyAccessor->getValue($item, '[senses]') ?? [] as $sense) {
                    foreach ($propertyAccessor->getValue($sense, '[definitions]') ?? [] as $definition) {
                        $entry->addDefinition($definition);
                    }
                }
                
                foreach ($propertyAccessor->getValue($item, '[pronunciations]') ?? [] as $pronunciation) {
                    $entry->addPronunciation($propertyAccessor->getValue($pronunciation, '[audioFile]'));
                }
            }
        }
        
        return $entry;
    }
}
