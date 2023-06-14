<?php

namespace App\Modules\NotesDairyOfSuccess\Model;

use DateTime;

class NotesDairyOfSuccessItem
{
    public int $id;
    public int $ownerID;
    public \DateTime $noteDate;
    public \DateTime $practiceDate;
    public string $text;

    /**
     *  @param int $id
     *  @param int $ownerID
     *  @param \DateTime $noteDate
     *  @param \DateTime $practiceDate;
     *  @param string|null $text;
     */

    public function __construct(int $id, int $ownerID, \DateTime $noteDate, \DateTime $practiceDate, ?string $text) {
        $this->id = $id;
        $this->ownerID = $ownerID;
        $this->noteDate = $noteDate;
        $this->practiceDate = $practiceDate;
        $this->text = $text;
    }

}