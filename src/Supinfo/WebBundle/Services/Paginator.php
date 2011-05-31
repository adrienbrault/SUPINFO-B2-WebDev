<?php

namespace Supinfo\WebBundle\Services;

use Doctrine\Orm\EntityManager;

class Paginator
{

    /*
     *  Properties.
     */

    private $entityManager;
    private $entityClassName;
    private $route;
    private $resultsPerPage;
    private $currentPage;

    private $resultsCount;
    private $maxPage;



    /*
     *  Getters and setters.
     */

    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }


    public function setEntityClassName($entityClassName)
    {
        $this->entityClassName = $entityClassName;
        return $this;
    }

    public function getEntityClassName()
    {
        return $this->entityClassName;
    }

    
    public function setResultsPerPage($resultsPerPage)
    {
        $this->resultsPerPage = $resultsPerPage;
        return $this;
    }

    public function getResultsPerPage()
    {
        return $this->resultsPerPage;
    }


    public function setRoute($route)
    {
        $this->route = $route;
        return $this;
    }

    public function getRoute()
    {
        return $this->route;
    }


    public function setCurrentPage($currentPage)
    {
        $this->currentPage = $currentPage;
        return $this;
    }

    public function getCurrentPage()
    {
        return $this->currentPage;
    }


    public function getResultsCount()
    {
        return $this->resultsCount;
    }


    public function getMaxPage()
    {
        return $this->maxPage;
    }
    

    public function getOffset()
    {
        return ($this->getCurrentPage() - 1) * $this->getResultsPerPage() + 1;
    }



    /*
     *
     */

    public function __construct()
    {
        $this->setResultsPerPage(10);
        $this->setCurrentPage(1);
    }



    /*
     *
     */

    private function fetchResultsCount()
    {
        if (!$this->entityManager) {
            throw new InvalidArgumentException('Paginator: An entityManager is required.');
        }

        // TODO: Using the entityRepository fictional count() method based on a createQuery would be better.
        
        $alias = 'e';
        $qb = $this->entityManager->createQueryBuilder();
        
        $qb ->select($qb->expr()->count($alias))
            ->from($this->entityClassName, $alias);

        $this->resultsCount = $qb->getQuery()->getSingleScalarResult();
    }

    public function currentPageExists($forceFetch = false)
    {
        if (null === $this->getResultsCount() || $forceFetch) {
            $this->fetchResultsCount();
        }

        return $this->getOffset() < $this->getResultsCount();
    }
}