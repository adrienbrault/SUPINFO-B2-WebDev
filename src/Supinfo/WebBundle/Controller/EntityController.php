<?php

namespace Supinfo\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Form;

abstract class EntityController extends Controller
{

    /*
     *  Properties.
     */

    protected $viewData = array();

    protected $entity;
    protected $entities;

    protected $entityForm;

    protected $paginator;


    
    /*
     *  Bundle namespaces stuff.
     */

    protected function getBundleDir()
    {
        return 'Supinfo';
    }

    protected function getBundleName()
    {
        return 'WebBundle';
    }

    protected function getBundleNamespace()
    {
        return $this->getBundleDir().'\\'.$this->getBundleName();
    }

    protected function getBundleFormat()
    {
        return $this->getBundleDir().$this->getBundleName();
    }



    /*
     *  View stuff.
     */

    public function render($view, array $parameters = array(), Response $response = null)
    {
        $this->viewData['form'] = $this->entityForm;
        $this->viewData['entity'] = $this->entity;
        $this->viewData['entities'] = $this->entities;
        $this->viewData['form'] = $this->entityForm instanceof Form ? $this->entityForm->createView() : null ;
        $this->viewData['paginator'] = $this->paginator;
        $this->viewData['routes'] = $this->getRoutes();

        return parent::render(
            $view,
            array_merge($this->viewData, $parameters),
            $response
        );
    }



    /*
     *  Pagination stuff.
     */

    protected function initPaginator($route)
    {
        $page = $this->get('request')->get('page');

        $this->paginator = $this->get('services.paginator');

        $this->paginator
            ->setEntityRepository($this->getEntityRepository())
            ->setRoute($route)
            ->setCurrentPage($page);

        if (!$this->paginator->currentPageExists()) {
            throw $this->createNotFoundException();
        }
    }



    /*
     *  Doctrine.
     */

    protected function getEntityManager()
    {
        return $this->get('doctrine')->getEntityManager();
    }

    protected function getEntityRepository()
    {
        return $this->getEntityManager()->getRepository($this->getEntityRepositoryIdentifier());
    }

    protected function fetchEntity()
    {
        $id = $this->get('request')->get('id');

        if (null !== $id) {
            $qb = $this->getEntityRepository()->selectByIdQB($id);
            $this->entity = $qb->getQuery()->getSingleResult();

            if (!$this->entity) {
               throw $this->createNotFoundException();
            }
        } else {
            $entityClassName = $this->getEntityClassName();
            $this->entity = new $entityClassName();
        }
    }

    protected function fetchEntities()
    {
        $this->initPaginator($this->getRoute('list'));

        $qb = $this->paginator->getCurrentPageQB();
        $this->entities = $qb->getQuery()->getResult();

        if (!$this->entities) {
            throw $this->createNotFoundException();
        }
    }



    /*
     *  Entity name stuff.
     */

    abstract protected function getEntityName();

    protected function getEntityNameSpace()
    {
        return $this->getBundleNamespace().'\Entity';
    }

    protected function getEntityClassName()
    {
        return $this->getEntityNameSpace().'\\'.$this->getEntityName();
    }

    protected function getEntityRepositoryIdentifier()
    {
        return $this->getBundleFormat().':'.$this->getEntityName();
    }



    /*
     *  Route stuff.
     */

    protected function getRoutes()
    {
        return array(
            'view' => $this->getEntityName().'_view',
            'list' => $this->getEntityName().'_list',
        );
    }

    protected function getRoute($key)
    {
        $routes = $this->getRoutes();

        if (!array_key_exists($key, $routes)) {
            throw new Exception(sprintf('EntityController: route "%s" not found', key));
        }

        return $routes[$key];
    }



    /*
     *  Actions.
     */

    protected function listAction()
    {
        $this->fetchEntities();
    }
    
}