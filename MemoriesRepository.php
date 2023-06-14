<?php

namespace App\Repository;

use App\Entity\Memories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MemoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Memories::class);
    }

    public function add(Memories $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    public function remove(Memories $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function save (Memories $noteGratitudeDiary) {
        $this->getEntityManager()->persist($noteGratitudeDiary);
    }

}