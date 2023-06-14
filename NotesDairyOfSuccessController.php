<?php

namespace App\Controller\Api\V1;

use App\Controller\JsonResponseTrait;
use App\Entity\NoteDairyOfSuccess;
use App\Entity\User;
use App\Modules\NotesDairyOfSuccess\NotesDairyOfSuccessService;
use Doctrine\Persistence\ManagerRegistry;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Repository\NoteDairyOfSuccessRepository;

class NotesDairyOfSuccessController extends AbstractController
{
    use JsonResponseTrait;

    #[Route('/dairies/success/notes', name: 'api_v1_notes_dairy_of_success')]
    public function list(Request $request, NotesDairyOfSuccessService $notesDairyOfSuccessService): JsonResponse
    {
        $ownerID = $request->query->get("id");
        if (isset($ownerID)) {
            return $this->successResponse($notesDairyOfSuccessService->getDairyOfSuccessList($ownerID));
        }
        return $this->successResponse([]);
    }

    #[Route('/dairies/success/notes/add', name: 'api_v1_success_notes_add')]
    public function addNote(ManagerRegistry $doctrine, Request $request, NoteDairyOfSuccessRepository $noteDairyOfSuccessRepository): JsonResponse
    {
        $json = json_decode($request->getContent(),true);
        if (isset($json['ownerID']) and isset($json['note_date']) and isset($json['text']) and isset($json['practice_date'])) {
            $note = new NoteDairyOfSuccess();
            $user = new User();
            $user->setId($json['ownerID']);
            $note->setNoteDate(DateTime::createFromFormat("Y-m-d H:i:s", $json['note_date']));
            $note->setPracticeDate(DateTime::createFromFormat("Y-m-d H:i:s", $json['practice_date']));
            $note->setText($json['text']);
            $note->setOwnerID($user);
            $entityManager = $doctrine->getManager();
            $entityManager->merge($note);
            $entityManager->flush();
            return $this->successResponse(["New note was appended"]);
        }
        return $this->successResponse(["Data uncorrected"]);
    }

    #[Route('/dairies/success/notes/update', name: 'api_v1_success_notes_update')]
    public function updateNote(ManagerRegistry $doctrine, Request $request, NoteDairyOfSuccessRepository $noteDairyOfSuccessRepository): JsonResponse
    {
        $json = json_decode($request->getContent(),true);

        if (isset($json['id'])) {
            $note = $noteDairyOfSuccessRepository->find($json['id']);
            if ($note != null) {
                if (isset($json['note_date'])) {
                    $note->setNoteDate(DateTime::createFromFormat("Y-m-d H:i:s", $json['note_date']));
                }
                if (isset($json['practice_date'])) {
                    $note->setPracticeDate(DateTime::createFromFormat("Y-m-d H:i:s", $json['practice_date']));
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

    #[Route('/dairies/success/notes/delete', name: 'api_v1_success_notes_delete')]
    public function deleteNote(ManagerRegistry $doctrine, Request $request, NoteDairyOfSuccessRepository $noteDairyOfSuccessRepository): JsonResponse
    {
        $id = $request->query->get("id");

        if (isset($id)) {
            $note = $noteDairyOfSuccessRepository->find($id);
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