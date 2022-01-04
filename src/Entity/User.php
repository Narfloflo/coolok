<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $firstname;

    #[ORM\Column(type: 'string', length: 30, nullable: true)]
    private $lastname;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    private $password;

    #[ORM\Column(type: 'text')]
    private $roles;

    #[ORM\Column(type: 'date', nullable: true)]
    private $birthday;

    #[ORM\Column(type: 'string', length: 30)]
    private $gender;

    #[ORM\Column(type: 'string', length: 60)]
    private $city;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'text')]
    private $passions;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private $options_search;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private $option_gender;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $option_age_min;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $option_age_max;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $option_rent_min;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $option_rent_max;

    #[ORM\OneToMany(targetEntity: FavoriteUser::class, mappedBy: 'user_id_a')]
    private $favoriteUsers;

    #[ORM\ManyToMany(targetEntity: Flat::class)]
    private $user_id;

    public function __construct()
    {
        $this->favoriteUsers = new ArrayCollection();
        $this->user_id = new ArrayCollection();
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

    public function getRoles(): ?string
    {
        return $this->roles;
    }

    public function setRoles(string $roles): self
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

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPassions(): ?string
    {
        return $this->passions;
    }

    public function setPassions(string $passions): self
    {
        $this->passions = $passions;

        return $this;
    }

    public function getOptionsSearch(): ?string
    {
        return $this->options_search;
    }

    public function setOptionsSearch(?string $options_search): self
    {
        $this->options_search = $options_search;

        return $this;
    }

    public function getOptionGender(): ?string
    {
        return $this->option_gender;
    }

    public function setOptionGender(?string $option_gender): self
    {
        $this->option_gender = $option_gender;

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

    public function getOptionAgeMax(): ?int
    {
        return $this->option_age_max;
    }

    public function setOptionAgeMax(?int $option_age_max): self
    {
        $this->option_age_max = $option_age_max;

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
     * @return Collection|FavoriteUser[]
     */
    public function getFavoriteUsers(): Collection
    {
        return $this->favoriteUsers;
    }

    public function addFavoriteUser(FavoriteUser $favoriteUser): self
    {
        if (!$this->favoriteUsers->contains($favoriteUser)) {
            $this->favoriteUsers[] = $favoriteUser;
            $favoriteUser->addUserIdA($this);
        }

        return $this;
    }

    public function removeFavoriteUser(FavoriteUser $favoriteUser): self
    {
        if ($this->favoriteUsers->removeElement($favoriteUser)) {
            $favoriteUser->removeUserIdA($this);
        }

        return $this;
    }

    /**
     * @return Collection|Flat[]
     */
    public function getUserId(): Collection
    {
        return $this->user_id;
    }

    public function addUserId(Flat $userId): self
    {
        if (!$this->user_id->contains($userId)) {
            $this->user_id[] = $userId;
        }

        return $this;
    }

    public function removeUserId(Flat $userId): self
    {
        $this->user_id->removeElement($userId);

        return $this;
    }
}
