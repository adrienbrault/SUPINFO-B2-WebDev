<?php

namespace Supinfo\WebBundle\Tool;

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
        return ($this->getCurrentPage() - 1) * $this->getResultsPerPage();
    }



    /*
     *  Defaults.
     */

    public function __construct()
    {
        $this->setResultsPerPage(10);
        $this->setCurrentPage(1);
    }



    /*
     *  Logic part.
     */

    private function fetchResultsCount()
    {
        if (!$this->entityRepository) {
            throw new InvalidArgumentException('Paginator: An entityRepository is required.');
        }

        $this->resultsCount = $this->getEntityRepository()->countQB()->getQuery()->getSingleScalarResult();
        $this->maxPage = ceil($this->resultsCount / $this->getResultsPerPage());

        if ($this->maxPage == 0) {
            $this->maxPage = 1;
        }
    }

    public function currentPageExists($forceFetch = false)
    {
        if (null === $this->getResultsCount() || $forceFetch) {
            $this->fetchResultsCount();
        }

        return $this->getCurrentPage() > 0 && $this->getCurrentPage() <= $this->getMaxPage();
    }



    /*
     *  Query builder helper.
     */

    public function getCurrentPageQB()
    {
        if (!$this->currentPageExists()) {
            throw new Exception('Paginator: can\'t return currentPageQB as the page does not exists.');
        }

        $qb = $this->getEntityRepository()->selectQB();

        $qb ->setFirstResult($this->getOffset())
            ->setMaxResults($this->getResultsPerPage());

        return $qb;
    }

}