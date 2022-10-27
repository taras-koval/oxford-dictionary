<?php

namespace App\Entity;

use App\Repository\CacheRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CacheRepository::class)]
class Cache
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $query = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $data = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuery(): ?string
    {
        return $this->query;
    }

    public function setQuery(string $query): self
    {
        $this->query = $query;

        return $this;
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function setData(?array $data): self
    {
        $this->data = $data;

        return $this;
    }
}
