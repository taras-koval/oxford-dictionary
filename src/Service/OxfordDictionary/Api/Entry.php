<?php

namespace App\Service\OxfordDictionary\Api;

use JetBrains\PhpStorm\ArrayShape;

class Entry
{
    private array $definitions = [];
    private array $pronunciations = [];
    
    #[ArrayShape([
        'definitions' => "array",
        'pronunciations' => "array"
    ])]
    public function toArray(): array
    {
        return [
            'definitions' => $this->definitions,
            'pronunciations' => $this->pronunciations,
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
    
    public function addPronunciation(?string $link): self
    {
        if (empty($link)) {
            return $this;
        }
        
        if (!in_array($link, $this->pronunciations)) {
            $this->pronunciations[] = $link;
        }
        
        return $this;
    }
    
    public function getDefinitions(): array
    {
        return $this->definitions;
    }
    
    public function getPronunciations(): array
    {
        return $this->pronunciations;
    }
}
