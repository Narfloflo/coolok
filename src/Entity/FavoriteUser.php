<?php

namespace App\Entity;

use App\Repository\FavoriteUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriteUserRepository::class)]
class FavoriteUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'favoriteUsers')]
    private $user_id_a;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $user_id_b;

    public function __construct()
    {
        $this->user_id_a = new ArrayCollection();
        $this->user_id_b = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|User[]
     */
    public function getUserIdA(): Collection
    {
        return $this->user_id_a;
    }

    public function addUserIdA(User $userIdA): self
    {
        if (!$this->user_id_a->contains($userIdA)) {
            $this->user_id_a[] = $userIdA;
        }

        return $this;
    }

    public function removeUserIdA(User $userIdA): self
    {
        $this->user_id_a->removeElement($userIdA);

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUserIdB(): Collection
    {
        return $this->user_id_b;
    }

    public function addUserIdB(User $userIdB): self
    {
        if (!$this->user_id_b->contains($userIdB)) {
            $this->user_id_b[] = $userIdB;
        }

        return $this;
    }

    public function removeUserIdB(User $userIdB): self
    {
        $this->user_id_b->removeElement($userIdB);

        return $this;
    }
}
