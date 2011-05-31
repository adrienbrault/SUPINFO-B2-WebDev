<?php

namespace Supinfo\WebBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

abstract class AdminController extends Controller
{
    /*
     *
     */

    protected $viewData = array();



    /*
     *
     */
    
    private function getAdminTypes()
    {
        return array(
            'edit',
            'delete',
            'list',
        );
    }



    /*
     * 
     */

    public function adminAction($admin_type)
    {
        $this->initialize();

        if (!in_array($admin_type, $this->getAdminTypes())) {
            throw $this->createNotFoundException();
        }

        $response = call_user_func(array($this, $admin_type.'Action'));

        return $response ?
            $response :
            $this->render($this->getViewName($admin_type), $this->viewData);
    }

    private function initialize()
    {
        if (!class_exists($this->getEntityClassName())) {
            throw new Exception('AdminController: Entity Class "'.$this->getEntityClassName().'" can not be found.');
        }
    }



    /*
     *
     */

    public function render($view, array $parameters = array(), Response $response = null)
    {
        return $this->render(
            $view,
            array_merge($this->viewData, $parameters),
            $response
        );
    }



    /*
     *
     */

    abstract protected function getEntityName();

    protected function getEntityNameSpace()
    {
        return 'Supinfo\WebBundle\Entity';
    }

    protected function getEntityClassName()
    {
        return $this->getEntityNameSpace().'\\'.$this->getEntityName();
    }


    /*
     *  View param.
     */

    protected function getViewFileName($admin_type)
    {
        return $admin_type.'.html.twig';
    }

    protected function getViewNamespace()
    {
        return 'SupinfoWebBundle:Admin\\'.$this->getEntityName();
    }

    protected function getViewFullName($admin_type)
    {
        return $this->getViewNamespace().':'.$this->getViewFileName($admin_type);
    }


    
    /*
     *  Abstract part.
     */
    
    abstract protected function addAction();
    abstract protected function editAction();
    abstract protected function deleteAction();
    abstract protected function listAction();
}