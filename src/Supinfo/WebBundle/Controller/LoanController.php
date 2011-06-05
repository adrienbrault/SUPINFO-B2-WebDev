<?php

namespace Supinfo\WebBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Supinfo\WebBundle\Entity\Loan;
use Supinfo\WebBundle\Form\NewLoanType;

class LoanController extends Controller
{

    public function newAction() {
        $em = $this->get('doctrine')->getEntityManager();
        $entityRepository = $em->getRepository('SupinfoWebBundle:Loan');

        $loan = $entityRepository->newEntity();

        $formBuilder = $this->get('form.factory')->createBuilder(new NewLoanType(), $loan);
        $form = $formBuilder->getForm();

        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            // Custom validation.
            if ($loan->getDateStart() >= $loan->getDateEnd()) {
                $form->addError(new FormError('DateEnd must be after DateStart.'));
            }

            if (!$this->get('security.context')->isGranted('ROLE_CLIENT')) {
                $form->addError(new FormError('You must be a client to create a loan.'));
            }

            if ($form->isValid()) {
                $loan->setUser($this->get('security.context')->getToken()->getUser());

                $em->persist($loan);
                $em->flush();

                return new RedirectResponse($this->generateUrl('client_Loan_edit', array('id' => $loan->getId())));
            }
        }

        return $this->render(
            'SupinfoWebBundle:Client:loan_new.html.twig',
            array(
                 'form' => $form->createView()
            )
        );
    }

}