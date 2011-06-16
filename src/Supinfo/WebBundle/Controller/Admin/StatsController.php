<?php

namespace Supinfo\WebBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;

class StatsController extends Controller
{

    public function statsAction()
    {
        // DEFAULTS DATES

        $baseDate = \DateTime::createFromFormat('Y-m-d', date('Y-m-1'));

        $dates = array(
            'dateStart' => clone $baseDate,
            'dateEnd' => clone $baseDate,
        );

        $dates['dateStart']->sub(new \DateInterval('P12M'));
        $dates['dateEnd']->add(new \DateInterval('P12M'));

        

        // FORM

        $form = $this->createFormBuilder($dates)
            ->add('dateStart', 'date', array('days' => array(1)))
            ->add('dateEnd', 'date', array('days' => array(1)))
            ->getForm();

        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->get('dateStart')->getData() >= $form->get('dateEnd')->getData()) {
                $form->addError(new FormError('Date start must be < to date end.'));
            }

            if ($form->isValid()) {
                $dates = $form->getData();
            }
        }


        
        // DATA

        $em = $this->get('doctrine')->getEntityManager();
        $repo = $em->getRepository('SupinfoWebBundle:Loan');
        $results = array();

        // Period will be loopable from Start to End with interval of 1 month.
        $period = new \DatePeriod($dates['dateStart'], new \DateInterval('P1M'), $dates['dateEnd']);

        $prevDate = null;
        foreach ($period as $date) {
            if ($prevDate !== null) {
                $results[] = array(
                    'count' => $repo->loanCountFromTo($prevDate, $date),
                    'from' => $prevDate,
                    'to' => $date
                );
            }

            $prevDate = $date;
        }

        

        // VIEW

        $canvasSize = max(900, count($results) * 50);

        return $this->render(
            'SupinfoWebBundle:Admin/Stats:stats.html.twig',
            array(
                'form' => $form->createView(),
                'results' => $results,
                'canvasSize' => $canvasSize
            )
        );
    }

}