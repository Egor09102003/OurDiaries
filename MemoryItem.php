<?php

namespace App\Modules\Memories\Model;

class MemoryItem
{
    public int $id;
    public int $ownerID;
    public string $tripID;
    public string $masterID;
    public ?string $typeTechnique;
    public ?string $text;

    public function __construct(int $id, int $ownerID, string $tripID, string $masterID, ?string $typeTechnique, ?string $text)
    {
        $this->id = $id;
        $this->ownerID = $ownerID;
        $this->tripID = $tripID;
        $this->masterID = $masterID;
        $this->typeTechnique = $typeTechnique;
        $this->text = $text;
    }

}