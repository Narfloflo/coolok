<?php

namespace App\Entity;

use App\Repository\FlatRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FlatRepository::class)]
class Flat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 30)]
    private $type;

    #[ORM\Column(type: 'string', length: 30)]
    private $furnished;

    #[ORM\Column(type: 'boolean')]
    private $owner;

    #[ORM\Column(type: 'string', length: 60)]
    private $city;

    #[ORM\Column(type: 'integer')]
    private $surface;

    #[ORM\Column(type: 'integer')]
    private $rooms;

    #[ORM\Column(type: 'integer')]
    private $free_space;

    #[ORM\Column(type: 'integer')]
    private $total_space;

    #[ORM\Column(type: 'integer')]
    private $rent;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'string', length: 30)]
    private $gender;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $flat_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getFurnished(): ?string
    {
        return $this->furnished;
    }

    public function setFurnished(string $furnished): self
    {
        $this->furnished = $furnished;

        return $this;
    }

    public function getOwner(): ?bool
    {
        return $this->owner;
    }

    public function setOwner(bool $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(int $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getRooms(): ?int
    {
        return $this->rooms;
    }

    public function setRooms(int $rooms): self
    {
        $this->rooms = $rooms;

        return $this;
    }

    public function getFreeSpace(): ?int
    {
        return $this->free_space;
    }

    public function setFreeSpace(int $free_space): self
    {
        $this->free_space = $free_space;

        return $this;
    }

    public function getTotalSpace(): ?int
    {
        return $this->total_space;
    }

    public function setTotalSpace(int $total_space): self
    {
        $this->total_space = $total_space;

        return $this;
    }

    public function getRent(): ?int
    {
        return $this->rent;
    }

    public function setRent(int $rent): self
    {
        $this->rent = $rent;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getFlatId(): ?User
    {
        return $this->flat_id;
    }

    public function setFlatId(?User $flat_id): self
    {
        $this->flat_id = $flat_id;

        return $this;
    }
}
