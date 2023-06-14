<?php

namespace App\Modules\Memories;

use App\Entity\MasterType;
use App\Entity\Memories;
use App\Modules\Memories\Model\MemoryItem;
use App\Repository\MemoriesRepository;
use App\Repository\MasterTypeRepository;
use App\Modules\Syncer\Model\SyncObjectMasterType;

class MemoryService
{
    public function __construct(private readonly MemoriesRepository $memoriesRepository, private readonly MasterTypeRepository $masterTypeRepository)
    {
    }

    public function getMemoriesByMaster(int $ownerID, string $masterID): array {
        $memories = $this->memoriesRepository->findBy(['masterID'=>$masterID, 'ownerID'=>$ownerID]);

        return array_map(
            fn (Memories $memory) => new MemoryItem(
                $memory->getID(),
                $memory->getOwnerID(),
                $memory->getTripID(),
                $memory->getMasterID(),
                $memory->getTypeTechnique(),
                $memory->getText()
            ),
            $memories
        );
    }

    public function getMemoriesByTechnique(int $ownerID, string $typeTechnique): array {
        $memories = $this->memoriesRepository->findBy(['typeTechnique'=>$typeTechnique, 'ownerID'=>$ownerID]);

        return array_map(
            fn (Memories $memory) => new MemoryItem(
                $memory->getID(),
                $memory->getOwnerID(),
                $memory->getTripID(),
                $memory->getMasterID(),
                $memory->getTypeTechnique(),
                $memory->getText()
            ),
            $memories
        );
    }

    public function getMemoryList(int $ownerID): array {
        $memories = $this->memoriesRepository->findBy(['ownerID'=>$ownerID]);

        return array_map(
            fn (Memories $memory) => new MemoryItem(
                $memory->getID(),
                $memory->getOwnerID(),
                $memory->getTripID(),
                $memory->getMasterID(),
                $memory->getTypeTechnique(),
                $memory->getText()
            ),
            $memories
        );
    }

    public function getMasters(int $ownerID): array {
        $memories = $this->memoriesRepository->findBy(['ownerID'=>$ownerID]);
        $mastersID = array_unique(array_map(fn (Memories $memory) => $memory->getMasterID(), $memories));
        $masters = array_map(
            fn (string $masterID) => $this->masterTypeRepository->findBy(['objID'=>$masterID]), $mastersID
        );
        return $masters[0];
        /*return array_map(
            fn (MasterType $master) => new SyncObjectMasterType(
                $master->getSyncDate(),
                $master->getObjID(),
                $master->getMasterTypeDescription(),
                $master->getName()
            ), $masters
        );*/
    }

    public function getTechniques(int $ownerID): array {
        $memories = $this->memoriesRepository->findBy(['ownerID'=>$ownerID]);

        return array_map(fn (Memories $memory) => $memory->getTypeTechnique(), $memories);
    }

    public function getPractice(int $practiceID): array {
        return $this->memoriesRepository->findBy(["id"=>$practiceID]);
    }
}