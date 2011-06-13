<?php

namespace Supinfo\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    public function indexAction()
    {
        $nextLoans = null;
        $currentLoans = null;

        if ($this->get('security.context')->isGranted('ROLE_CLIENT')) {
            $em = $em = $this->get('doctrine')->getEntityManager();
            $entityRepository = $em->getRepository('SupinfoWebBundle:Loan');

            $nextLoans = $entityRepository->get5NextLoans();
            $currentLoans = $entityRepository->getCurrentLoans();
        }

        return $this->render(
            'SupinfoWebBundle:Default:homepage.html.twig',
            array(
                'nextLoans' => $nextLoans,
                'currentLoans' => $currentLoans,
            )
        );
    }
}