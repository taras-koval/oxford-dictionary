<?php

namespace App\Service\OxfordDictionary\Api;

use JetBrains\PhpStorm\ArrayShape;

class Entry
{
    private ?string $lexicalCategory;
    
    private array $definitions = [];
    private array $pronunciations = [];
    private array $examples = [];
    
    #[ArrayShape([
        'lexicalCategory' => "string",
        'definitions' => "array",
        'pronunciations' => "array",
        'examples' => 'array'
    ])]
    public function toArray(): array
    {
        return [
            'lexicalCategory' => $this->lexicalCategory,
            'definitions' => $this->definitions,
            'pronunciations' => $this->pronunciations,
            'examples' => $this->examples
        ];
    }
    
    public function addDefinition(?string $definition): self
    {
        if (empty($definition)) {
            return $this;
        }
        
        if (!in_array($definition, $this->definitions)) {
            $this->definitions[] = $definition;
        }
        
        return $this;
    }
    
    public function getDefinitions(): array
    {
        return $this->definitions;
    }
    
    public function addPronunciation(?string $item): self
    {
        if (empty($item)) {
            return $this;
        }
        
        if (!in_array($item, $this->pronunciations)) {
            $this->pronunciations[] = $item;
        }
        
        return $this;
    }
    
    public function getPronunciations(): array
    {
        return $this->pronunciations;
    }
    
    public function addExamples(?string $item): self
    {
        if (empty($item)) {
            return $this;
        }
        
        if (!in_array($item, $this->examples)) {
            $this->examples[] = $item;
        }
        
        return $this;
    }
    
    public function getExamples(): array
    {
        return $this->examples;
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
