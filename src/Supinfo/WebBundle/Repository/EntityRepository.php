<?php

namespace Supinfo\WebBundle\Repository;

use Doctrine\ORM\EntityRepository as DoctrineEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Supinfo\WebBundle\Entity;

class EntityRepository extends DoctrineEntityRepository
{
    public function getAlias()
    {
        return 'e';
    }

    protected function createQB()
    {
        return $this->getEntityManager()->createQueryBuilder();
    }

    public function selectQB()
    {
        $qb = $this->createQB();
        
        return $qb
            ->select($this->getAlias())
            ->from($this->getEntityName(), $this->getAlias());
    }

    public function selectByIdQB($id)
    {
        $qb = $this->selectQB();

        $qb ->andWhere(
            $qb->expr()->eq($this->getAlias().'.id', ':id')
        );

        $qb->setParameter('id', $id);

        return $qb;
    }

    public function countQB()
    {
        $qb = $this->selectQB();
        
        return $qb->select(
            $qb->expr()->count($this->getAlias())
        );
    }

    public function newEntity() {
        $className = $this->getEntityName();
        return new $className;
    }
}