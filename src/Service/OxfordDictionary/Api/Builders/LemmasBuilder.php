<?php

namespace App\Service\OxfordDictionary\Api\Builders;

use App\Service\OxfordDictionary\Api\Entry;
use App\Service\OxfordDictionary\Api\Lemma;
use Symfony\Component\PropertyAccess\PropertyAccess;

class LemmasBuilder
{
    /**
     * @param  array  $data
     * @return Lemma
     */
    public function build(array $data): Lemma
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        $lexicalEntries = $propertyAccessor->getValue($data, '[results][0][lexicalEntries]');
        
        return $this->buildLemma($lexicalEntries);
    }
    
    private function buildLemma($lexicalEntry): Lemma
    {
        $lemma = new Lemma();
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
    
        $lemma->setLanguage($propertyAccessor->getValue($lexicalEntry, '[0][language]'));
        $lemma->setInflectionOf($propertyAccessor->getValue($lexicalEntry, '[0][inflectionOf][0][text]'));
        $lemma->setLexicalCategory($propertyAccessor->getValue($lexicalEntry, '[0][lexicalCategory][text]'));
        
        return $lemma;
    }
}
