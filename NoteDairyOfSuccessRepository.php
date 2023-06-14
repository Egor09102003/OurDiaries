<?php

namespace App\Repository;

use App\Entity\NoteDairyOfSuccess;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class NoteDairyOfSuccessRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NoteDairyOfSuccess::class);
    }

    public function add(NoteDairyOfSuccess $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function remove(NoteDairyOfSuccess $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function save (NoteDairyOfSuccess $noteGratitudeDiary) {
        $this->getEntityManager()->persist($noteGratitudeDiary);
    }
}
