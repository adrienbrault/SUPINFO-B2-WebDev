<?php

namespace Supinfo\WebBundle\Controller\Client;

class ArticleController extends EntityController
{

    public function getEntityName()
    {
        return 'Article';
    }

    public function viewAction($id)
    {
        $this->fetchEntity(array('id' => $id));

        return $this->render(
            'SupinfoWebBundle:Client\Article:view.html.twig'
        );
    }

    public function listAction($page)
    {
        $this->initPaginator(array(
            'current_page' => $page
        ));

        $this->entities = $this->paginator->getCurrentPageResults();

        return $this->render(
            'SupinfoWebBundle:Client\Article:list.html.twig'
        );
    }

}