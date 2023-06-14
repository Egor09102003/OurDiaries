<?php

namespace App\Controller\Api\V1;

use App\Controller\JsonResponseTrait;
use App\Entity\MasterType;
use App\Entity\Memories;
use App\Entity\Trip;
use App\Entity\User;
use App\Repository\MemoriesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Modules\Memories\MemoryService;
use Symfony\Component\HttpFoundation\Response;

class MemoriesController extends AbstractController
{
    use JsonResponseTrait;
    #[Route('/dairies/memory', name: 'api_v1_memory')]
    public function listMemories(Request $request, MemoryService $memoryService): JsonResponse
    {
        $ownerID = $request->query->get("ownerID");
        if (isset($ownerID)) {
            return $this->successResponse([$memoryService->getMemoryList($ownerID)]);
        }
        return $this->successResponse([]);
    }

    /*#[Route('/dairies/masters', name: 'api_v1_masters')]
    public function listMasters(Request $request, MemoryService $memoryService): JsonResponse
    {
        $json = json_decode($request->getContent(),true);
        if (isset($json['ownerID'])) {
            return $this->successResponse($memoryService->getMasters($json['ownerID']));
        }
        return $this->successResponse([]);
    }*/

    #[Route('/dairies/techniques', name: 'api_v1_techniques')]
    public function listTechniques(Request $request, MemoryService $memoryService): JsonResponse
    {
        $json = json_decode($request->getContent(),true);
        if (isset($json['ownerID'])) {
            return $this->successResponse($memoryService->getTechniques($json['ownerID']));
        }
        return $this->successResponse([]);
    }

    #[Route('/dairies/practice_info', name: 'api_v1_practice_info')]
    public function getPractice(Request $request, MemoryService $memoryService): JsonResponse
    {
        $json = json_decode($request->getContent(),true);
        if (isset($json['id'])) {
            return $this->successResponse($memoryService->getPractice($json['id']));
        }
        return $this->errorResponse('Practice not found', [],Response::HTTP_NOT_FOUND);
    }

    //_______________________________Добавление, обновление, удаление____________________________________

    #[Route('/dairies/memory/add', name: 'api_v1_memories_add')]
    public function addMemory(ManagerRegistry $doctrine, Request $request, MemoriesRepository $memoriesRepository): JsonResponse
    {
        $json = json_decode($request->getContent(),true);
        if (isset($json['ownerID']) and isset($json['typeTechnique']) and isset($json['text']) and isset($json['tripID'])and isset($json['masterID'])) {
            $memory = new Memories();
            //$user = new User();
            //$user->setId($json['ownerID']);
            $memory->setMasterID((new MasterType())->setObjId($json['masterID']));
            $memory->setOwnerID((new User)->setId($json['ownerID']));
            $memory->setTripID((new Trip)->setObjId($json['tripID']));
            $memory->setTypeTechnique($json['typeTechnique']);
            $memory->setText($json['text']);
            $entityManager = $doctrine->getManager();
            $entityManager->merge($memory);
            $entityManager->flush();
            return $this->successResponse(["New memory was appended"]);
        }
        return $this->successResponse(["Data uncorrected"]);
    }

    #[Route('/dairies/memory/update', name: 'api_v1_memories_update')]
    public function updateMemory(ManagerRegistry $doctrine, Request $request, MemoriesRepository $memoriesRepository): JsonResponse
    {
        $json = json_decode($request->getContent(),true);

        if (isset($json['id'])) {
            $memory = $memoriesRepository->find($json['id']);
            if ($memory != null) {
                if (isset($json['text'])) {
                    $memory->setText($json['text']);
                }
                if (isset($json['typeTechnique'])) {
                    $memory->setTypeTechnique($json['typeTechnique']);;
                }
                if (isset($json['tripID'])) {
                    $memory->setTripID((new Trip)->setObjId($json['tripID']));
                }
                if (isset($json['masterID'])) {
                    $memory->setMasterID((new MasterType)->setObjId($json['masterID']));
                }
                $entityManager = $doctrine->getManager();
                $entityManager->merge($memory);
                $entityManager->flush();
                return $this->successResponse(["Memory was changed"]);
            }
        }
        return $this->successResponse(["Memory not found"]);
    }

    #[Route('/dairies/memory/delete', name: 'api_v1_memories_delete')]
    public function deleteMemory(ManagerRegistry $doctrine, Request $request, MemoriesRepository $memoriesRepository): JsonResponse
    {
        $id = $request->query->get("id");

        if (isset($id)) {
            $note = $memoriesRepository->find($id);
            if ($note != null) {
                $entityManager = $doctrine->getManager();
                $entityManager->remove($note);
                $entityManager->flush();
                return $this->successResponse(["Memory was deleted"]);
            }
        }
        return $this->successResponse(["Memory not found"]);
    }
}