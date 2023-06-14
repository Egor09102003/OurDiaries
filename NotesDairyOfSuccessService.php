<?php

namespace App\Modules\NotesDairyOfSuccess;

use App\Entity\NoteDairyOfSuccess;
use App\Modules\NotesDairyOfSuccess\Model\NotesDairyOfSuccessItem;
use App\Repository\NoteDairyOfSuccessRepository;

class NotesDairyOfSuccessService
{
    public function __construct(private readonly NoteDairyOfSuccessRepository $noteDairyOfSuccessRepository)
    {
    }

    public function getDairyOfSuccessList(int $userID): array
    {
        $notes = $this->noteDairyOfSuccessRepository->findBy(['ownerID'=>$userID]);
        return array_map(
            fn (NoteDairyOfSuccess $note) => new NotesDairyOfSuccessItem(
                $note->getID(),
                $note->getOwnerID(),
                $note->getNoteDate(),
                $note->getPracticeDate(),
                $note->getText()
            ),
            $notes
        );
    }

}