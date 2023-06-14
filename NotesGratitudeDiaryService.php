<?php

namespace App\Modules\NotesGratitudeDiary;

use App\Entity\NoteGratitudeDiary;
use App\Modules\NotesGratitudeDiary\Model\NoteGratitudeDiaryItem;
use App\Repository\NoteGratitudeDiaryRepository;

class NotesGratitudeDiaryService
{
    public function __construct(private readonly NoteGratitudeDiaryRepository $noteGratitudeDiaryRepository)
    {
    }

    public function getNotesGratitudeDiaryList(int $userID): array {
        $notes = $this->noteGratitudeDiaryRepository->findBy(['ownerID'=>$userID]);

        return array_map(
            fn (NoteGratitudeDiary $note) => new NoteGratitudeDiaryItem(
                $note->getID(),
                $note->getOwnerID(),
                $note->getDate(),
                $note->getText()
            ),
           $notes
        );
    }

}