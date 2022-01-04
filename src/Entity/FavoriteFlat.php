<?php

namespace App\Entity;

use App\Repository\FavoriteFlatRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriteFlatRepository::class)]
class FavoriteFlat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $user_id;

    #[ORM\ManyToOne(targetEntity: Flat::class)]
    private $flat_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getFlatId(): ?Flat
    {
        return $this->flat_id;
    }

    public function setFlatId(?Flat $flat_id): self
    {
        $this->flat_id = $flat_id;

        return $this;
    }
}
