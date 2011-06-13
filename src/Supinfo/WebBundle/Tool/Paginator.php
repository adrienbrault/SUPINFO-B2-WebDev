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
    private $routeParams = array();
    private $selectQB;

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

        if ($this->getSelectQB()) {
            $qb = clone $this->getSelectQB(); // If we don't clone it, the currentPageQB will have the count
            $qb->select(
                $qb->expr()->count(
                    $qb->getRootAlias()
                )
            );

            $this->resultsCount = $qb->getQuery()->getSingleScalarResult();
        } else {
            $this->resultsCount = $this->getEntityRepository()->count();
        }

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

        $qb = $this->getSelectQB() ? $this->getSelectQB() : $this->getEntityRepository()->selectQB();

        $qb ->setFirstResult($this->getOffset())
            ->setMaxResults($this->getResultsPerPage());

        return $qb;
    }

    public function getCurrentPageResults() {
        return $this->getCurrentPageQB()->getQuery()->getResult();
    }

    public function setRouteParams($routeParams)
    {
        $this->routeParams = $routeParams;
        return $this;
    }

    public function getRouteParams()
    {
        return $this->routeParams;
    }

    public function setSelectQB($selectQB)
    {
        $this->selectQB = $selectQB;
        return $this;
    }

    public function getSelectQB()
    {
        return $this->selectQB;
    }

}