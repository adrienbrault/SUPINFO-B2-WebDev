<?php

namespace Supinfo\WebBundle\Controller\Client;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchController extends Controller {

    public function searchAction()
    {
        $request = $this->get('request');
        $query = stripslashes($request->get('query'));
        $results = array();

        if (!empty($query)) {
            $em = $this->get('doctrine')->getEntityManager();

            $repositories = array(
                'User' => $em->getRepository('SupinfoWebBundle:User'),
                'Loan' => $em->getRepository('SupinfoWebBundle:Loan'),
                'Article' => $em->getRepository('SupinfoWebBundle:Article')
            );


            foreach ($repositories as $key => $repository) {
                $results[$key] = $repository->search($query);
            }
        }

        return $this->render(
            'SupinfoWebBundle:Client:search.html.twig',
            array(
                'search_query' => $query,
                'results' => $results
            )
        );
    }

}