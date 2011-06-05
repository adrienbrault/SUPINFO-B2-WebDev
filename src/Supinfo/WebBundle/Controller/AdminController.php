<?php

namespace Supinfo\WebBundle\Controller;

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

    protected function getEntityClassName() {
        return 'Supinfo\WebBundle\Entity\\'.$this->getEntityName();
    }

    public function adminAction($_admin_type)
    {
        $this->initialize();

        $response = call_user_func(array($this, $_admin_type.'Action'));

        return $response ?
            $response :
            $this->renderAdminView($_admin_type);
    }

    private function initialize()
    {
        if (!class_exists($this->getEntityClassName())) {
            throw new \Exception('AdminController: Entity Class "'.$this->getEntityClassName().'" can not be found.');
        }
    }



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
        $viewFullName = 'SupinfoWebBundle:Admin:'.$admin_type.'.html.twig';

        if (!$this->viewExists($viewFullName)) {
            $viewFullName = $this->getDefaultAdminViewFullName($admin_type);
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
            'new' => $this->getEntityName().'_admin_new',
            'edit' => $this->getEntityName().'_admin_edit',
            'delete' => $this->getEntityName().'_admin_delete',
            'list' => $this->getEntityName().'_admin_list',
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

    protected function editAction()
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
    }

    protected function deleteAction()
    {
        $this->fetchEntity();

        $em = $this->getEntityManager();
        $em->remove($this->entity);
        $em->flush();

        $this->get('session')->setFlash('notice', $this->getEntityName().' successfully deleted.');

        // Redirect to the list.
        return $this->redirectToList();
    }

    protected function listAction()
    {
        $this->fetchEntities();
    }
    
}