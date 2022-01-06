<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FlatRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FlatRepository::class)]
class Flat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Assert\NotBlank(
        message: 'Vous devez saisir un type de logement'
    )]
    #[ORM\Column(type: 'string', length: 30)]
    private $type;

    #[Assert\NotBlank(
        message: 'Vous devez saisir ce champ'
    )]
    #[ORM\Column(type: 'string', length: 30)]
    private $furnished;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'ownerflats')]
    #[ORM\JoinColumn(nullable: false)]
    private $owner;

    #[Assert\NotBlank(
        message: 'Veuillez indiquer une ville.'
    )]
    #[ORM\Column(type: 'string', length: 60)]
    private $city;
    
    #[Assert\GreaterThan(
        value: 0,
        message: 'La surface doit être supérieur à 0.'
    )]
    #[ORM\Column(type: 'integer')]
    private $surface;

    #[Assert\GreaterThan(
        value: 0,
        message: 'Vous devez indiquer le nombre de pièces.'
    )]
    #[ORM\Column(type: 'integer')]
    private $rooms;

    #[Assert\GreaterThanOrEqual(
        value: 0,
        message: 'Vous devez indiquer le nombre de place disponible.'
    )]
    #[ORM\Column(type: 'integer')]
    private $free_space;
    //private $freeSpace;

    #[Assert\GreaterThan(
        value: 0,
        message: 'Vous devez indiquer le nombre de place total.'
    )]
    #[ORM\Column(type: 'integer')]
    private $total_space;

    #[Assert\GreaterThanOrEqual(
        value: 0,
        message: 'Vous devez indiquer le montant du loyer par personne.'
    )]
    #[ORM\Column(type: 'integer')]
    private $rent;

    #[Assert\Length(
        min: 10,
        max: 1000,
        minMessage: 'Votre description doit contenir au minimum {{ limit }} caractères',
        maxMessage: 'Votre description doit contenir au maximum {{ limit }} caractères',
    )]
    #[ORM\Column(type: 'text')]
    private $description;

    #[Assert\NotBlank(
        message: 'Veuillez indiquer une préférence'
    )]
    #[ORM\Column(type: 'string', length: 30)]
    private $gender;

    #[Assert\NotBlank(
        message: 'Veuillez indiquer une sa disponiblité'
    )]
    #[ORM\Column(type: 'boolean')]
    private $available;

    #[Assert\File(
        maxSize: '2M',
        mimeTypes: ['image/jpeg', 'image/png'],
        mimeTypesMessage: 'Veuillez transferer un fichier image valide',
        maxSizeMessage: 'Ce fichier est trop volumineux: ({{ size }} {{ suffix }}). Poids maximum: {{ limit }} {{ suffix }}.'
    )]
    #[ORM\Column(type: 'json')]
    private $images = [];

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

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
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

    public function getAvailable(): ?bool
    {
        return $this->available;
    }

    public function setAvailable(bool $available): self
    {
        $this->available = $available;

        return $this;
    }

    public function getImages(): ?array
    {
        return $this->images;
    }

    public function setImages(array $images): self
    {
        $this->images = $images;

        return $this;
    }
}
