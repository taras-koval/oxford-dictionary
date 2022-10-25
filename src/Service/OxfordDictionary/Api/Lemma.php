<?php

namespace App\Service\OxfordDictionary\Api;

use JetBrains\PhpStorm\ArrayShape;

class Lemma
{
    private ?string $language;
    private ?string $inflectionOf;
    private ?string $lexicalCategory;
    
    #[ArrayShape([
        'language' => "string",
        'inflectionOf' => "string",
        'lexicalCategory' => "string",
    ])]
    public function toArray(): array
    {
        return [
            'language' => $this->language,
            'inflectionOf' => $this->inflectionOf,
            'lexicalCategory' => $this->lexicalCategory,
        ];
    }
    
    public function getLanguage(): ?string
    {
        return $this->language;
    }
    
    public function setLanguage(?string $language): void
    {
        $this->language = $language;
    }
    
    public function getInflectionOf(): ?string
    {
        return $this->inflectionOf;
    }
    
    public function setInflectionOf(?string $inflectionOf): void
    {
        $this->inflectionOf = $inflectionOf;
    }
    
    public function getLexicalCategory(): ?string
    {
        return $this->lexicalCategory;
    }
    
    public function setLexicalCategory(?string $lexicalCategory): void
    {
        $this->lexicalCategory = $lexicalCategory;
    }
    
}
