<?php

namespace App\Entity;

use App\Repository\MemoriesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemoriesRepository::class)]
#[ORM\Table(name: '`memories`')]
class Memories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'usersMemory')]
    #[ORM\JoinColumn(name: "ownerID",referencedColumnName: "id")]
    private ?User $ownerID;

    #[ORM\OneToOne(inversedBy: 'usersTrip', targetEntity: Trip::class)]
    #[ORM\JoinColumn(name: "tripID",referencedColumnName: "obj_id")]
    private Trip $tripID;

    #[ORM\ManyToOne(targetEntity: MasterType::class, inversedBy: 'memoryMaster')]
    #[ORM\JoinColumn(name: "masterID",referencedColumnName: "obj_id")]
    private MasterType $masterID;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $typeTechnique;


    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $text;

    public function getID(): int
    {
        return $this->id;
    }

    public function setID(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getOwnerID(): int
    {
        return $this->ownerID->getId();
    }

    public function setOwnerID(User $newOwnerID): self
    {
        $this->ownerID = $newOwnerID;

        return $this;
    }

    public function getTripID(): string
    {
        return $this->tripID->getObjId();
    }

    public function setTripID(Trip $newTripID): self
    {
        $this->tripID = $newTripID;

        return $this;
    }

    public function getMasterID(): string
    {
        return $this->masterID->getObjID();
    }

    public function setMasterID(MasterType $newMasterID): self
    {
        $this->masterID = $newMasterID;

        return $this;
    }

    public function getTypeTechnique(): string
    {
        return $this->typeTechnique;
    }

    public function setTypeTechnique(string $typeTechnique): self
    {
        $this->typeTechnique = $typeTechnique;

        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

}