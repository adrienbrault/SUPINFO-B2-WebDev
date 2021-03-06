<?php

namespace Supinfo\WebBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use Supinfo\WebBundle\Entity\User;

/**
 * LoanRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LoanRepository extends EntityRepository
{

    public function selectQB() {
        $qb = parent::selectQB();

        $qb->orderBy(
            $qb->getRootAlias().'.dateStart',
            'ASC'
        );

        $qb->addSelect(
            'al'
        )->leftJoin(
            $qb->getRootAlias().'.articlesLoan',
            'al'
        );

        $qb->addSelect(
            'ala'
        )->leftJoin(
            'al.article',
            'ala'
        );

        return $qb;
    }

    public function next5LoansQB()
    {
        $qb = $this->selectQB();

        $qb->andWhere(
            $this->getFilterExpr(2, $qb)
        )->setMaxResults(
            5
        );

        return $qb;
    }

    public function next5Loans()
    {
        return $this->next5LoansQB()->getQuery()->getResult();
    }

    public function currentLoansQB()
    {
        $qb = $this->selectQB();

        // andWhere does not work with Andx expr.
        $qb->andWhere(
            $this->getFilterExpr(1, $qb)->__toString()
        );

        return $qb;
    }

    public function currentLoans()
    {
        return $this->currentLoansQB()->getQuery()->getResult();
    }

    public function selectQBWithFilters(array $filters)
    {
        $qb = $this->selectQB();

        $orExpr = $qb->expr()->orx();
        foreach ($filters as $filterKey) {
            $orExpr->add($this->getFilterExpr($filterKey, $qb));
        }
        $qb->andWhere($orExpr);

        return $qb;
    }

    public function getFilterExpr($filter, QueryBuilder $qb)
    {
        $expr = null;

        switch ($filter) {
            case 0: // Ended
            {
                $expr = $qb->expr()->lt(
                    $qb->getRootAlias().'.dateEnd',
                    'CURRENT_DATE()'
                );
            } break;

            case 1: // Ongoing
            {
                $expr = $qb->expr()->andx(
                    $qb->expr()->lt(
                        $qb->getRootAlias().'.dateStart',
                        'CURRENT_DATE()'
                    ),
                    $qb->expr()->gt(
                        $qb->getRootAlias().'.dateEnd',
                        'CURRENT_DATE()'
                    )
                );
            } break;

            case 2: // Ucomming
            {
                $expr = $qb->expr()->gt(
                    $qb->getRootAlias().'.dateStart',
                    'CURRENT_DATE()'
                );
            } break;
        }

        return $expr;
    }

    public function searchQB($query)
    {
        $qb = parent::searchQB($query);

        $qb->setParameter('query_like', '%'.$query.'%');
        $qb->setParameter('query_id', preg_match('/^5[0-9]{4}$/', $query) ? substr($query, 1) : $query);

        return $qb;
    }

    public function getSearchExpr(QueryBuilder $qb)
    {
        $expr = parent::getSearchExpr($qb);

        $expr->add(
            $qb->expr()->like(
                $qb->getRootAlias().'.reason',
                ':query_like'
            )
        );
        
        $expr->add(
            $qb->expr()->eq(
                $qb->getRootAlias().'.id',
                ':query_id'
            )
        );

        return $expr;
    }

    public function loansByQB(User $user)
    {
        $qb = $this->selectQB();

        $qb->andWhere(
            $qb->expr()->eq(
                $qb->getRootAlias().'.user',
                ':user'
            )
        );
        
        $qb->setParameter('user', $user);

        return $qb;
    }

    public function loansBy(User $user)
    {
        return $this->loansByQB($user)->getQuery()->getResult();
    }

    public function loanCountFromTo(\DateTime $start, \DateTime $end)
    {
        $qb = $this->countQB();

        $ra = $qb->getRootAlias();

        $qb->andWhere("
        (
            (
                $ra.dateStart <= :date_start
            ) AND (
                :date_start < $ra.dateEnd
            )
        )
        OR (
            (
                $ra.dateStart < :date_end
            ) AND (
                :date_end <= $ra.dateEnd
            )
        )
        ");

        $qb->setParameter('date_start', $start, \Doctrine\DBAL\Types\Type::DATETIME);
        $qb->setParameter('date_end', $end, \Doctrine\DBAL\Types\Type::DATETIME);

        return $qb->getQuery()->getSingleScalarResult();
    }

}