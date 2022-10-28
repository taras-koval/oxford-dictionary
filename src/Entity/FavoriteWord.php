<?php

namespace App\Entity;

use App\Repository\FavoriteWordRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriteWordRepository::class)]
#[ORM\Table(name: 'favorite_words')]
class FavoriteWord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Searches::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Searches $word = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWord(): Searches
    {
        return $this->word;
    }

    public function setWord(Searches $word): self
    {
        $this->word = $word;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
