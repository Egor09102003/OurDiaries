<?php

namespace App\Entity;

use App\Repository\NoteDairyOfSuccessRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NoteDairyOfSuccessRepository::class)]
#[ORM\Table(name: 'dairy_of_success')]

class NoteDairyOfSuccess
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'usersNote')]
    #[ORM\JoinColumn(name: "ownerID",referencedColumnName: "id")]
    private ?User $ownerID;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTime $noteDate;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTime $practiceDate;

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

    public function setOwnerID(User $newOwner): self
    {
        $this->ownerID = $newOwner;

        return $this;
    }

    public function getNoteDate(): ?\DateTime
    {
        return $this->noteDate ?? null;
    }

    public function setNoteDate(?\DateTime $noteDate): self
    {
        $this->noteDate = $noteDate;

        return $this;
    }

    public function getPracticeDate(): ?\DateTime
    {
        return $this->practiceDate ?? null;
    }

    public function setPracticeDate(?\DateTime $practiceDate): self
    {
        $this->practiceDate = $practiceDate;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text ?? null;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }
}