<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private string $username;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private string $password;

    #[ORM\Column(type: 'string', length: 255, nullable: true, unique: true)]
    private ?string $apiToken;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private $phone;

    #[ORM\Column(type: 'string', length: 512, nullable: true)]
    private $description;

    #[ORM\Column(type: 'boolean')]
    private $isGuide;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $name;

    /*#[ORM\ManyToMany(targetEntity: Trip::class, mappedBy: 'tripId')]
    private $trips;*/

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $avatar;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $lastSuccessfulSyncDate;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $lastSyncTryDate;

    #[ORM\OneToMany(mappedBy: 'tripUser', targetEntity: TripUserRole::class, orphanRemoval: true)]
    private $tripsRoles;

    #[ORM\OneToMany(mappedBy: 'ownerID', targetEntity: NoteDairyOfSuccess::class, orphanRemoval: true)]
    private $usersSuccessNote;

    #[ORM\OneToMany(mappedBy: 'ownerID', targetEntity: NoteGratitudeDiary::class, orphanRemoval: true)]
    private $usersNote;

    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private ?string $homeLocationID;

    #[ORM\Column(type: 'string', length: 16, nullable: true)]
    private ?string $sex;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $apiTokenExpiresAt = null;

    #[ORM\Column(options: ["default" => false])]
    private bool $isMaster = false;

    #[ORM\Column(nullable: true)]
    private ?array $socialNetworks = [];

    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true)]
    private ?array $masterTypesIDs = [];

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $masterStory = null;

    #[ORM\Column(nullable: true)]
    private ?array $skills = [];

    #[ORM\Column(nullable: true)]
    private ?array $currentRating = [];

    public function __construct()
    {
//        $this->trips = new ArrayCollection();
        $this->tripsRoles = new ArrayCollection();
        $this->isGuide = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getApiToken(): ?string
    {
        return $this->apiToken;
    }

    public function setApiToken(?string $apiToken): self
    {
        $this->apiToken = $apiToken;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

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

    public function getIsGuide(): ?bool
    {
        return $this->isGuide;
    }

    public function setIsGuide(bool $isGuide): self
    {
        $this->isGuide = $isGuide;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

/*    /**
     * @return Collection|Trip[]
     */
 /*   public function getTrips(): Collection
    {
        return $this->trips;
    }

    public function addTrip(Trip $trip): self
    {
        if (!$this->trips->contains($trip)) {
            $this->trips[] = $trip;
            $trip->addTripId($this);
        }

        return $this;
    }

    public function removeTrip(Trip $trip): self
    {
        if ($this->trips->removeElement($trip)) {
            $trip->removeTripId($this);
        }

        return $this;
    }
*/
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getLastSuccessfulSyncDate(): ?\DateTimeInterface
    {
        return $this->lastSuccessfulSyncDate;
    }

    public function setLastSuccessfulSyncDate(?\DateTimeInterface $lastSuccessfulSyncDate): self
    {
        $this->lastSuccessfulSyncDate = $lastSuccessfulSyncDate;

        return $this;
    }

    public function getLastSyncTryDate(): ?\DateTimeInterface
    {
        return $this->lastSyncTryDate;
    }

    public function setLastSyncTryDate(?\DateTimeInterface $lastSyncTryDate): self
    {
        $this->lastSyncTryDate = $lastSyncTryDate;

        return $this;
    }

    /**
     * @return Collection<int, TripUserRole>
     */
    public function getTripsRoles(): Collection
    {
        return $this->tripsRoles;
    }

    public function addTripsRole(TripUserRole $tripsRole): self
    {
        if (!$this->tripsRoles->contains($tripsRole)) {
            $this->tripsRoles[] = $tripsRole;
            $tripsRole->setTripUser($this);
        }

        return $this;
    }

    public function removeTripsRole(TripUserRole $tripsRole): self
    {
        if ($this->tripsRoles->removeElement($tripsRole)) {
            // set the owning side to null (unless already changed)
            if ($tripsRole->getTripUser() === $this) {
                $tripsRole->setTripUser(null);
            }
        }

        return $this;
    }

    public function getHomeLocationID(): ?string
    {
        return $this->homeLocationID;
    }

    public function setHomeLocationID(?string $homeLocationID): self
    {
        $this->homeLocationID = $homeLocationID;

        return $this;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(?string $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function getApiTokenExpiresAt(): ?\DateTimeImmutable
    {
        return $this->apiTokenExpiresAt;
    }

    public function setApiTokenExpiresAt(?\DateTimeImmutable $apiTokenExpiresAt): self
    {
        $this->apiTokenExpiresAt = $apiTokenExpiresAt;

        return $this;
    }

    public function isTokenExpired(): bool
    {
        return new \DateTimeImmutable() > $this->apiTokenExpiresAt;
    }

    public function getIsMaster(): ?bool
    {
        return $this->isMaster;
    }

    public function setIsMaster(bool $isMaster): self
    {
        $this->isMaster = $isMaster;

        return $this;
    }

    public function getSocialNetworks(): array
    {
        return $this->socialNetworks ?? [];
    }

    public function setSocialNetworks(?array $socialNetworks): self
    {
        $this->socialNetworks = $socialNetworks;

        return $this;
    }

    public function getMasterTypesIDs(): ?array
    {
        return $this->masterTypesIDs;
    }

    public function setMasterTypesIDs(?array $masterTypesIDs): self
    {
        $this->masterTypesIDs = $masterTypesIDs;

        return $this;
    }

    public function getMasterStory(): ?string
    {
        return $this->masterStory;
    }

    public function setMasterStory(?string $masterStory): self
    {
        $this->masterStory = $masterStory;

        return $this;
    }

    public function getSkills(): ?array
    {
        return $this->skills;
    }

    public function setSkills(?array $skills): self
    {
        $this->skills = $skills;

        return $this;
    }

    public function getCurrentRating(): array
    {
        return $this->currentRating;
    }

    public function setCurrentRating(?array $currentRating): self
    {
        $this->currentRating = $currentRating;

        return $this;
    }

    public function getUsersSuccessNote(): ?int
    {
        return $this->usersSuccessNote;
    }
}
