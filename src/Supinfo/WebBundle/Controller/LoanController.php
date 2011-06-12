<?php

namespace Supinfo\WebBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Supinfo\WebBundle\Entity\Loan;
use Supinfo\WebBundle\Entity\Article;
use Supinfo\WebBundle\Entity\ArticleLoan;
use Supinfo\WebBundle\Form\NewLoanType;
use Supinfo\WebBundle\Form\EditLoanType;
use Supinfo\WebBundle\Form\LoanAddArticleType;

class LoanController extends Controller
{

    public function newAction() {
        $em = $this->get('doctrine')->getEntityManager();
        $entityRepository = $em->getRepository('SupinfoWebBundle:Loan');

        $loan = $entityRepository->newEntity();

        $form = $this->get('form.factory')
            ->createBuilder(new NewLoanType(), $loan)
            ->getForm();

        $request = $this->get('request');
        if ($request->getMethod() == 'POST' && $request->get($form->getName())) {
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

                $this->get('session')->setFlash('notice', 'Loan successfully created.');

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

    public function editAction($id) {
        $em = $this->get('doctrine')->getEntityManager();
        $entityRepository = $em->getRepository('SupinfoWebBundle:Loan');

        $loan = $entityRepository->selectOneById($id);

        if (!$loan) {
            throw $this->createNotFoundException();
        }

        $form = $this->get('form.factory')
            ->createBuilder(new EditLoanType(), $loan)
            ->getForm();

        $formAddArticle = $this->get('form.factory')
            ->createBuilder(new LoanAddArticleType())
            ->getForm();

        $request = $this->get('request');
        if ($request->getMethod() == 'POST' && $request->get($form->getName())) {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em->persist($loan);
                $em->flush();

                $this->get('session')->setFlash('notice', 'Loan successfully edited.');

                return new RedirectResponse($this->generateUrl('client_Loan_edit', array('id' => $loan->getId())));
            }
        } else if ($request->getMethod() == 'POST' && $request->get($formAddArticle->getName())) {
            $formAddArticle->bindRequest($request);

            if ($formAddArticle->isValid()) {
                $articleId = $formAddArticle->get('id')->getData();
                if (preg_match('/^5([0-9]{4})$/', $articleId, $matches)) {
                    $articleId = $matches[1];
                }

                $article = $em->getRepository('SupinfoWebBundle:Article')
                    ->selectOneById($articleId);

                if ($article) {
                    $articleLoanCount = $em
                        ->getRepository('SupinfoWebBundle:ArticleLoan')
                        ->countById($article->getId(), $loan->getId());

                    if ($articleLoanCount > 0) {
                        $formAddArticle->addError(new FormError('This article has already been added.'));
                    } else {
                        $articleLoan = new ArticleLoan();
                        $articleLoan->setArticle($article);
                        $articleLoan->setLoan($loan);

                        $em->persist($articleLoan);
                        $em->flush();

                        $this->get('session')->setFlash('notice', 'Article added.');

                        return new RedirectResponse($this->generateUrl('client_Loan_edit', array('id' => $loan->getId())));
                    }
                } else {
                    $formAddArticle->addError(new FormError('Article does not exists.'));
                }
            }
        }

        return $this->render(
            'SupinfoWebBundle:Client:loan_edit.html.twig',
            array(
                'form' => $form->createView(),
                'loan' => $loan,
                'formAddArticle' => $formAddArticle->createView(),
            )
        );
    }

    public function deleteArticleLoanAction($loanId, $articleId)
    {
        $em = $this->get('doctrine')->getEntityManager();
        $entityRepository = $em->getRepository('SupinfoWebBundle:ArticleLoan');

        $articleLoan = $entityRepository->selectOneByIds($articleId, $loanId);

        if (!$articleLoan) {
            throw $this->createNotFoundException();
        }

        $em->remove($articleLoan);
        $em->flush();

        $this->get('session')->setFlash('notice', 'Article successfully removed from Loan.');

        return $this->redirect($this->generateUrl('client_Loan_edit', array('id' => $loanId)));
    }

}