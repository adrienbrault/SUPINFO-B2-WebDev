<?php

namespace Supinfo\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SupinfoWebBundle:Default:homepage.html.twig');
    }
}