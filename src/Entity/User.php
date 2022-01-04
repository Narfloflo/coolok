<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 30, nullable: true)]
    private $firstname;

    #[ORM\Column(type: 'string', length: 30, nullable: true)]
    private $lastname;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    private $password;

    #[ORM\Column(type: 'json', nullable: true)]
    private $roles = [];

    #[ORM\Column(type: 'date', nullable: true)]
    private $birthday;

    #[ORM\Column(type: 'string', length: 30, nullable: true)]
    private $gender;

    #[ORM\Column(type: 'string', length: 60, nullable: true)]
    private $city;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\Column(type: 'text', nullable: true)]
    private $passions;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private $option_search;

    #[ORM\Column(type: 'string', length: 20)]
    private $option_gender;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $option_age_max;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $option_age_min;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $option_rent_min;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $option_rent_max;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Flat::class)]
    private $ownerflats;

    #[ORM\ManyToMany(targetEntity: Flat::class)]
    #[ORM\JoinTable(name: "favorite_flat")]
    private $favorite_flat;

    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'users')]
    #[ORM\JoinTable(name: "favorite_user")]
    private $favorite_user;

    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'favorite_user')]
    private $users;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $picture;

    public function __construct()
    {
        $this->ownerflats = new ArrayCollection();
        $this->favorite_flat = new ArrayCollection();
        $this->favorite_user = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(?array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPassions(): ?string
    {
        return $this->passions;
    }

    public function setPassions(?string $passions): self
    {
        $this->passions = $passions;

        return $this;
    }

    public function getOptionSearch(): ?string
    {
        return $this->option_search;
    }

    public function setOptionSearch(?string $option_search): self
    {
        $this->option_search = $option_search;

        return $this;
    }

    public function getOptionGender(): ?string
    {
        return $this->option_gender;
    }

    public function setOptionGender(string $option_gender): self
    {
        $this->option_gender = $option_gender;

        return $this;
    }

    public function getOptionAgeMax(): ?int
    {
        return $this->option_age_max;
    }

    public function setOptionAgeMax(?int $option_age_max): self
    {
        $this->option_age_max = $option_age_max;

        return $this;
    }

    public function getOptionAgeMin(): ?int
    {
        return $this->option_age_min;
    }

    public function setOptionAgeMin(?int $option_age_min): self
    {
        $this->option_age_min = $option_age_min;

        return $this;
    }

    public function getOptionRentMin(): ?int
    {
        return $this->option_rent_min;
    }

    public function setOptionRentMin(?int $option_rent_min): self
    {
        $this->option_rent_min = $option_rent_min;

        return $this;
    }

    public function getOptionRentMax(): ?int
    {
        return $this->option_rent_max;
    }

    public function setOptionRentMax(?int $option_rent_max): self
    {
        $this->option_rent_max = $option_rent_max;

        return $this;
    }

    /**
     * @return Collection|Flat[]
     */
    public function getOwnerflats(): Collection
    {
        return $this->ownerflats;
    }

    public function addOwnerflat(Flat $ownerflat): self
    {
        if (!$this->ownerflats->contains($ownerflat)) {
            $this->ownerflats[] = $ownerflat;
            $ownerflat->setOwner($this);
        }

        return $this;
    }

    public function removeOwnerflat(Flat $ownerflat): self
    {
        if ($this->ownerflats->removeElement($ownerflat)) {
            // set the owning side to null (unless already changed)
            if ($ownerflat->getOwner() === $this) {
                $ownerflat->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Flat[]
     */
    public function getFavoriteFlat(): Collection
    {
        return $this->favorite_flat;
    }

    public function addFavoriteFlat(Flat $favoriteFlat): self
    {
        if (!$this->favorite_flat->contains($favoriteFlat)) {
            $this->favorite_flat[] = $favoriteFlat;
        }

        return $this;
    }

    public function removeFavoriteFlat(Flat $favoriteFlat): self
    {
        $this->favorite_flat->removeElement($favoriteFlat);

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getFavoriteUser(): Collection
    {
        return $this->favorite_user;
    }

    public function addFavoriteUser(self $favoriteUser): self
    {
        if (!$this->favorite_user->contains($favoriteUser)) {
            $this->favorite_user[] = $favoriteUser;
        }

        return $this;
    }

    public function removeFavoriteUser(self $favoriteUser): self
    {
        $this->favorite_user->removeElement($favoriteUser);

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(self $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addFavoriteUser($this);
        }

        return $this;
    }

    public function removeUser(self $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeFavoriteUser($this);
        }

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }
}
