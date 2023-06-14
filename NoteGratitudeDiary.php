<?php
namespace App\Entity;

use App\Repository\NoteGratitudeDiaryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NoteGratitudeDiaryRepository::class)]
#[ORM\Table(name: '`gratitude_diary`')]
class NoteGratitudeDiary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'usersNote')]
    #[ORM\JoinColumn(name: "ownerID",referencedColumnName: "id")]
    private ?User $ownerID;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $date;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date ?? null;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

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