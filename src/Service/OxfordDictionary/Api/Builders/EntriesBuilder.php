<?php

namespace App\Service\OxfordDictionary\Api\Builders;

use App\Service\OxfordDictionary\Api\Entry;
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
        $lexicalEntries = $propertyAccessor->getValue($data, '[results][0][lexicalEntries]');
        
        foreach ($lexicalEntries as $lexicalEntry) {
            $entries[] = $this->buildEntry($lexicalEntry);
        }
        
        return $entries;
    }
    
    private function buildEntry($lexicalEntry): Entry
    {
        $entry = new Entry();
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        
        $entry->setLexicalCategory($propertyAccessor->getValue($lexicalEntry, '[lexicalCategory][text]'));
        
        foreach ($propertyAccessor->getValue($lexicalEntry, '[entries]') ?? [] as $item) {
            foreach ($propertyAccessor->getValue($item, '[senses]') ?? [] as $sense) {
                
                foreach ($propertyAccessor->getValue($sense, '[definitions]') ?? [] as $definition) {
                    $entry->addDefinition($definition);
                }
    
                foreach ($propertyAccessor->getValue($sense, '[examples]') ?? [] as $example) {
                    $entry->addExamples($propertyAccessor->getValue($example, '[text]'));
                }
            }
            
            foreach ($propertyAccessor->getValue($item, '[pronunciations]') ?? [] as $pronunciation) {
                $entry->addPronunciation($propertyAccessor->getValue($pronunciation, '[audioFile]'));
            }
        }
        
        return $entry;
    }
}
