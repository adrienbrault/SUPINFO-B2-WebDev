<?php

namespace Supinfo\WebBundle\Controller\Client;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Supinfo\WebBundle\Tool\Paginator;

abstract class EntityController extends Controller
{

    /*
     *  VAR
     */

    protected $viewData = array();
    protected $entity;
    protected $entities;
    protected $paginator;

    protected $entityManager;
    protected $entityRepository;



    /*
     *  Doctrine helpers.
     */

    public function getEntityManager()
    {
        if (!$this->entityManager) {
            $this->entityManager = $this->get('doctrine')->getEntityManager();
        }

        return $this->entityManager;
    }

    public function getEntityRepository()
    {
        if (!$this->entityRepository) {
            $this->entityRepository = $this->getEntityManager()->getRepository('SupinfoWebBundle:'.$this->getEntityName());
        }
        return $this->entityRepository;
    }



    /*
     *
     */

    abstract public function getEntityName();



    /*
     *  DB
     */

    protected function fetchEntity(array $parameters = array())
    {
        $this->entity = $this->getEntityRepository()->selectOneById($parameters['id']);

        if (!$this->entity) {
            throw $this->createNotFoundException();
        }
    }



    /*
     *
     */

    public function render($view, array $parameters = array(), Response $response = null)
    {
        $this->viewData['entity'] = $this->entity;
        $this->viewData['entities'] = $this->entities;
        $this->viewData['paginator'] = $this->paginator;
        $this->viewData['entityName'] = $this->getEntityName();

        return parent::render(
            $view,
            array_merge($this->viewData, $parameters),
            $response
        );
    }



    /*
     *  Paginator.
     */

    protected function initPaginator(array $parameters = array())
    {
        // Managing page.
        $this->paginator = new Paginator($parameters);

        $this->paginator
            ->setEntityRepository($this->getEntityRepository())
            ->setRoute('client_'.$this->getEntityName().'_list');

        if (!$this->paginator->currentPageExists()) {
            throw $this->createNotFoundException();
        }

        $this->entities = $this->paginator->getCurrentPageResults();
    }

    
}