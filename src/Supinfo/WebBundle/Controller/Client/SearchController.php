<?php

namespace Supinfo\WebBundle\Controller\Client;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchController extends Controller {

    public function searchAction()
    {
        $request = $this->get('request');
        $query = stripslashes($request->get('query'));
        $results = array();

        $paths = array(
            'User' => 'client_User_view',
            'Loan' => 'client_Loan_view',
            'Article' => 'client_Article_view'
        );

        if (!empty($query)) {
            $em = $this->get('doctrine')->getEntityManager();

            $repositories = array(
                'User' => $em->getRepository('SupinfoWebBundle:User'),
                'Loan' => $em->getRepository('SupinfoWebBundle:Loan'),
                'Article' => $em->getRepository('SupinfoWebBundle:Article')
            );

            foreach ($repositories as $key => $repository) {
                $repoResults = $repository->search($query);

                if (count($repoResults) > 0) {
                    $results[$key] = $repoResults;
                }
            }

            if (count($results) == 1 && count(current($results)) == 1) {
                $type = current(array_keys($results));
                $result = current($results[$type]);

                return $this->redirect($this->generateUrl($paths[$type], array('id' => $result->getId())));
            }
        }

        return $this->render(
            'SupinfoWebBundle:Client\Search:search.html.twig',
            array(
                'search_query' => $query,
                'results' => $results,
                'paths' => $paths
            )
        );
    }

}