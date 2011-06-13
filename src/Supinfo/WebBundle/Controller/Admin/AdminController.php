<?php

namespace Supinfo\WebBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Form;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class AdminController extends Controller
{

    /*
     *  Properties.
     */

    protected $viewData = array();

    protected $entity;
    protected $entityClone;
    protected $entities;

    protected $entityForm;

    protected $paginator;



    /*
     * 
     */

    abstract protected function getEntityName();



    /*
     *  View override.
     */

    public function render($view, array $parameters = array(), Response $response = null)
    {
        $this->viewData['form'] = $this->entityForm;
        $this->viewData['entity'] = $this->entity;
        $this->viewData['entities'] = $this->entities;
        $this->viewData['form'] = $this->entityForm instanceof Form ? $this->entityForm->createView() : null ;
        $this->viewData['paginator'] = $this->paginator;
        $this->viewData['routes'] = $this->getRoutes();
        $this->viewData['entityName'] = $this->getEntityName();

        return parent::render(
            $view,
            array_merge($this->viewData, $parameters),
            $response
        );
    }

    protected function renderAdminView($admin_type)
    {
        $viewFullName = 'SupinfoWebBundle:Admin\\'.$this->getEntityName().':'.$admin_type.'.html.twig';

        if (!$this->viewExists($viewFullName)) {
            $viewFullName = 'SupinfoWebBundle:Admin:'.$admin_type.'.html.twig';
        }
        
        return $this->render($viewFullName, $this->viewData);
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
        return $this->getEntityManager()->getRepository('SupinfoWebBundle:'.$this->getEntityName());
    }

    protected function fetchEntity()
    {
        $id = $this->get('request')->get('id');

        if (null !== $id) {
            $this->entity = $this->getEntityRepository()->selectOneById($id);

            if (!$this->entity) {
                throw $this->createNotFoundException();
            }
        } else {
            $this->entity = $this->getEntityRepository()->newEntity();
        }
    }

    protected function fetchEntities()
    {
        $this->initPaginator($this->getRoute('list'));

        $this->entities = $this->paginator->getCurrentPageResults();
    }



    /*
     *
     */

    protected function initPaginator($route)
    {
        $page = $this->get('request')->get('page');

        $this->paginator = new \Supinfo\WebBundle\Tool\Paginator();

        $this->paginator
            ->setEntityRepository($this->getEntityRepository())
            ->setRoute($route)
            ->setCurrentPage($page);

        if (!$this->paginator->currentPageExists()) {
            throw $this->createNotFoundException();
        }
    }



    /*
     *  Form stuff.
     */

    protected function getEntityFormBuilder()
    {
        $entityTypeClassName = 'Supinfo\WebBundle\Form\\'.$this->getEntityName().'Type';
        $entityType = new $entityTypeClassName();

        return $this->get('form.factory')->createBuilder($entityType, $this->entity);
    }

    protected function createEntityForm()
    {
        $this->entityClone = clone $this->entity;
        $this->entityForm = $this->getEntityFormBuilder()->getForm();
    }

    protected function saveFormEntity()
    {
        $em = $this->getEntityManager();
        $em->persist($this->entity);
        $em->flush();
    }

    protected function entityFormIsValid()
    {
        return $this->entityForm->isValid();
    }



    /*
     *  View stuff.
     */

    protected function viewExists($viewName)
    {
        return $this->get('templating')->exists($viewName);
    }



    /*
     *  Routes stuff.
     */

    protected function getRoutes()
    {
        $adminRoutes = array(
            'new' => 'admin_'.$this->getEntityName().'_new',
            'edit' => 'admin_'.$this->getEntityName().'_edit',
            'delete' => 'admin_'.$this->getEntityName().'_delete',
            'list' => 'admin_'.$this->getEntityName().'_list',
        );

        return $adminRoutes;
    }

    protected function redirectToList($page = null)
    {
        $redirectUrl = $this->generateUrl($this->getRoute('list'), array('page' => $page));
        return $this->redirect($redirectUrl);
    }

    protected function redirectToEdit()
    {
        $redirectUrl = $this->generateUrl($this->getRoute('edit'), array('id' => $this->entity->getId()));
        return $this->redirect($redirectUrl);
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

    public function editAction()
    {
        $this->fetchEntity();
        $this->createEntityForm();

        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $this->entityForm->bindRequest($request);

            if ($this->entityFormIsValid()) {
                $this->saveFormEntity();

                $this->get('session')->setFlash('notice', $this->getEntityName().' successfully modified.');

                // Redirect to the edit page.
                return $this->redirectToList();
            }
        }

        return $this->renderAdminView('edit');
    }

    public function deleteAction()
    {
        $this->fetchEntity();

        $em = $this->getEntityManager();
        $em->remove($this->entity);
        $em->flush();

        $this->get('session')->setFlash('notice', $this->getEntityName().' successfully deleted.');

        // Redirect to the list.
        return $this->redirectToList();
    }

    public function listAction()
    {
        $this->fetchEntities();

        return $this->renderAdminView('list');
    }
    
}