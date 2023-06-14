<?php

namespace App\Repository;

use App\Entity\NoteGratitudeDiary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class NoteGratitudeDiaryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NoteGratitudeDiary::class);
    }

    public function add(NoteGratitudeDiary $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function remove(NoteGratitudeDiary $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function save (NoteGratitudeDiary $noteGratitudeDiary) {
        $this->getEntityManager()->persist($noteGratitudeDiary);
    }
}
