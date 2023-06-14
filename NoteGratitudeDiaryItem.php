<?php

namespace App\Modules\NotesGratitudeDiary\Model;

use DateTime;

class NoteGratitudeDiaryItem
{
    public int $id;
    public int $ownerID;
    public DateTime $date;
    public ?string $text;

    /**
     * @param int $id
     * @param int $ownerID
     * @param DateTime $date
     * @param string|null $text
     */
    public function __construct(int $id, int $ownerID, DateTime $date, ?string $text)
    {
        $this->id = $id;
        $this->ownerID = $ownerID;
        $this->date = $date;
        $this->text = $text;
    }
}