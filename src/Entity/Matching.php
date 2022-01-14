<?php

namespace App\Entity;

use App\Repository\MatchingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatchingRepository::class)]
class Matching
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'mymatch')]
    #[ORM\JoinColumn(nullable: false)]
    private $userA;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'matchinginput')]
    #[ORM\JoinColumn(nullable: false)]
    private $userB;

    #[ORM\Column(type: 'datetime')]
    private $matchingA_at;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $matchingB_at;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $fullMatchingAt;

    public function __construct()
    {
        $this->matchingA_at = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserA(): ?User
    {
        return $this->userA;
    }

    public function setUserA(?User $userA): self
    {
        $this->userA = $userA;

        return $this;
    }

    public function getUserB(): ?User
    {
        return $this->userB;
    }

    public function setUserB(?User $userB): self
    {
        $this->userB = $userB;

        return $this;
    }

    public function getMatchingAAt(): ?\DateTimeInterface
    {
        return $this->matchingA_at;
    }

    public function setMatchingAAt(\DateTimeInterface $matchingA_at): self
    {
        $this->matchingA_at = $matchingA_at;

        return $this;
    }

    public function getMatchingBAt(): ?\DateTimeInterface
    {
        return $this->matchingB_at;
    }

    public function setMatchingBAt(\DateTimeInterface $matchingB_at): self
    {
        $this->matchingB_at = $matchingB_at;

        return $this;
    }

    public function getFullMatchingAt(): ?\DateTimeInterface
    {
        return $this->fullMatchingAt;
    }

    public function setFullMatchingAt(?\DateTimeInterface $fullMatchingAt): self
    {
        $this->fullMatchingAt = $fullMatchingAt;

        return $this;
    }
}
