<?php

namespace App\Controller\Api\V1;

use App\Controller\JsonResponseTrait;
use App\Entity\NoteGratitudeDiary;
use App\Entity\User;
use App\Repository\NoteGratitudeDiaryRepository;
use Cassandra\Date;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Modules\NotesGratitudeDiary\NotesGratitudeDiaryService;

class NotesGratitudeDiaryController extends AbstractController
{
    use JsonResponseTrait;

    #[Route('/dairies/gratitude/notes', name: 'api_v1_gratitude_notes')]
    public function list(Request $request, NotesGratitudeDiaryService $notesGratitudeDiaryService): JsonResponse
    {
        $ownerID = $request->query->get("id");
        if (isset($ownerID)) {
            return $this->successResponse($notesGratitudeDiaryService->getNotesGratitudeDiaryList($ownerID));
        }
        return $this->successResponse([]);
    }

    #[Route('/dairies/gratitude/notes/add', name: 'api_v1_gratitude_notes_add')]
    public function addNote(ManagerRegistry $doctrine, Request $request, NotesGratitudeDiaryService $notesGratitudeDiaryService): JsonResponse
    {
        $json = json_decode($request->getContent(),true);
        if (isset($json['ownerID']) and isset($json['date']) and isset($json['text'])) {
            $note = new NoteGratitudeDiary();
            $user = new User();
            $user->setId($json['ownerID']);
            $note->setDate(DateTime::createFromFormat("Y-m-d H:i:s", $json['date']));
            $note->setText($json['text']);
            $note->setOwnerID($user);
            $entityManager = $doctrine->getManager();
            $entityManager->merge($note);
            $entityManager->flush();
            return $this->successResponse(["New note was appended"]);
        }
        return $this->successResponse(["Data uncorrected"]);
    }

    #[Route('/dairies/gratitude/notes/update', name: 'api_v1_gratitude_notes_update')]
    public function updateNote(ManagerRegistry $doctrine, Request $request, NoteGratitudeDiaryRepository $noteGratitudeDiaryRepository): JsonResponse
    {
        $json = json_decode($request->getContent(),true);

        if (isset($json['id'])) {
            $note = $noteGratitudeDiaryRepository->find($json['id']);
            if ($note != null) {
                if (isset($json['date'])) {
                    $note->setDate(DateTime::createFromFormat("Y-m-d H:i:s", $json['date']));
                }
                if (isset($json['text'])) {
                    $note->setText($json['text']);
                }
                $entityManager = $doctrine->getManager();
                $entityManager->merge($note);
                $entityManager->flush();
                return $this->successResponse(["Note was changed"]);
            }
        }
        return $this->successResponse(["Note not found"]);
    }

    #[Route('/dairies/gratitude/notes/delete', name: 'api_v1_gratitude_notes_delete')]
    public function deleteNote(ManagerRegistry $doctrine, Request $request, NoteGratitudeDiaryRepository $noteGratitudeDiaryRepository): JsonResponse
    {
        $id = $request->query->get("id");

        if (isset($id)) {
            $note = $noteGratitudeDiaryRepository->find($id);
            if ($note != null) {
                $entityManager = $doctrine->getManager();
                $entityManager->remove($note);
                $entityManager->flush();
                return $this->successResponse(["Note was deleted"]);
            }
        }
        return $this->successResponse(["Note not found"]);
    }

}