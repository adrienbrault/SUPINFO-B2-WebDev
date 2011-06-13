<?php

namespace Supinfo\WebBundle\Controller\Client;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{

    public function viewAction($id)
    {
        $em = $this->get('doctrine')->getEntityManager();
        $entityRepository = $em->getRepository('SupinfoWebBundle:User');

        $user = $entityRepository->selectOneById($id);

        if (!$user) {
            throw $this->createNotFoundException();
        }

        $loans = $em->getRepository('SupinfoWebBundle:Loan')->loansBy($user);

        return $this->render(
            'SupinfoWebBundle:Client:user_view.html.twig',
            array(
                'user' => $user,
                'loans' => $loans
            )
        );
    }

}