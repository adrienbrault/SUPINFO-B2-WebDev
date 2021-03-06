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

    public function selectAll()
    {
        return $this->selectQB()->getQuery()->getResult();
    }

    public function selectByIdQB($id)
    {
        $qb = $this->selectQB();

        $qb ->andWhere(
            $qb->expr()->eq($qb->getRootAlias().'.id', ':id')
        );

        $qb->setParameter('id', $id);

        return $qb;
    }

    public function selectOneById($id) {
        return current($this->selectByIdQB($id)->getQuery()->getResult());
    }

    public function countQB()
    {
        $qb = $this->createQB();
        
        return $qb->select(
            $qb->expr()->count($this->getAlias())
        )->from(
            $this->getEntityName(),
            $this->getAlias()
        );
    }

    public function count()
    {
        return $this->countQB()->getQuery()->getSingleScalarResult();
    }

    public function newEntity()
    {
        $className = $this->getEntityName();
        return new $className;
    }

    public function searchQB($query)
    {
        $qb = $this->selectQB();

        $qb->andWhere(
            $this->getSearchExpr($qb)
        );

        $qb->setParameter('query', $query);

        return $qb;
    }

    public function search($query)
    {
        return $this->searchQB($query)->getQuery()->getResult();
    }

    public function getSearchExpr(QueryBuilder $qb)
    {
        return $qb->expr()->orx(
            $qb->expr()->eq(
                $qb->getRootAlias().'.id',
                ':query'
            )
        );
    }
}