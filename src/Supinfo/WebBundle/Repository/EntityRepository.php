<?php

namespace Supinfo\WebBundle\Repository;

use Doctrine\ORM\EntityRepository as DoctrineEntityRepository;
use Doctrine\ORM\QueryBuilder;

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
        return $this->createQB()
            ->select($this->getAlias())
            ->from($this->getEntityName(), $this->getAlias());
    }

    public function countQB()
    {
        $qb = $this->selectQB();
        
        return $qb->select(
            $qb->expr()->count($this->getAlias())
        );
    }
}