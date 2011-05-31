<?php

namespace Supinfo\WebBundle\Services;

use Supinfo\WebBundle\Repository\EntityRepository;

class Paginator
{

    /*
     *  Properties.
     */

    private $entityRepository;
    private $route;
    private $resultsPerPage;
    private $currentPage;

    private $resultsCount;
    private $maxPage;



    /*
     *  Getters and setters.
     */

    public function setEntityRepository(EntityRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;
        return $this;
    }

    public function getEntityRepository()
    {
        return $this->entityRepository;
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
     *  Query helper.
     */

    public function getPageCriteria()
    {
        
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
        if (!$this->entityRepository) {
            throw new InvalidArgumentException('Paginator: An entityRepository is required.');
        }

        $this->resultsCount = $this->getEntityRepository()->countQB()->getQuery()->getSingleScalarResult();
    }

    public function currentPageExists($forceFetch = false)
    {
        if (null === $this->getResultsCount() || $forceFetch) {
            $this->fetchResultsCount();
        }

        return $this->getOffset() < $this->getResultsCount();
    }



    /*
     *
     */

    public function getCurrentPageQB()
    {
        $qb = $this->getEntityRepository()->selectQB();

        $qb ->setFirstResult($this->getOffset())
            ->setMaxResults($this->getResultsPerPage());

        return $qb;
    }

}