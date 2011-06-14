<?php

namespace Supinfo\WebBundle\Controller\Client;

class UserController extends EntityController
{

    public function getEntityName()
    {
        return 'User';
    }

    public function viewAction($id)
    {
        $this->fetchEntity(array('id' => $id));

        $loans = $this->getEntityManager()->getRepository('SupinfoWebBundle:Loan')->loansBy($this->entity);

        return $this->render(
            'SupinfoWebBundle:Client\User:view.html.twig',
            array(
                'loans' => $loans
            )
        );
    }

}