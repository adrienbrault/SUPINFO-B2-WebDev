<?php

namespace Supinfo\WebBundle\Controller\Client;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

use Supinfo\WebBundle\Form\LoanAddArticleType;
use Supinfo\WebBundle\Entity\ArticleLoan;

class ArticleController extends EntityController
{

    public function getEntityName()
    {
        return 'Article';
    }

    public function viewAction($id)
    {
        $this->fetchEntity(array('id' => $id));

        $form = null;
        if ($this->get('security.context')->isGranted('ROLE_CLIENT')) {
                $form = $formBuilder = $this->get('form.factory')
                ->createBuilder(new LoanAddArticleType())
                ->getForm();

            $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bindRequest($request);

                if ($form->isValid()) {
                    $loanId = $form->get('id')->getData();
                    if (preg_match('/^5([0-9]{4})$/', $loanId)) {
                        $loanId = substr($loanId, 1);
                    }

                    $loan = $this->getEntityManager()
                        ->getRepository('SupinfoWebBundle:Loan')
                        ->selectOneById($loanId);

                    if (!$loan) {
                        $form->addError(new FormError('Loan does not exists.'));
                    } else {
                        $articleLoanCount = $this->getEntityManager()
                            ->getRepository('SupinfoWebBundle:ArticleLoan')
                            ->countById($this->entity->getId(), $loan->getId());

                        if ($articleLoanCount > 0) {
                            $form->addError(new FormError('This article has already been added.'));
                        } else if (!$this->get('security.context')->isGranted('ROLE_ADMIN')
                                && $loan->getUser() != $this->get('security.context')->getToken()->getUser()) {
                            $form->addError(new FormError('You must be the owner of a loan to add an article to it.'));
                        } else {
                            $articleLoan = new ArticleLoan();
                            $articleLoan->setArticle($this->entity);
                            $articleLoan->setLoan($loan);
                            $articleLoan->setDateStart($loan->getDateStart());
                            $articleLoan->setDateEnd($loan->getDateEnd());

                            $this->getEntityManager()->persist($articleLoan);
                            $this->getEntityManager()->flush();

                            $this->get('session')->setFlash('notice', 'Article added to loan.');

                            return new RedirectResponse($this->generateUrl(
                                'client_Loan_edit',
                                array('id' => $loan->getId())
                            ));
                        }
                    }
                }
            }
        }

        return $this->render(
            'SupinfoWebBundle:Client\Article:view.html.twig',
            array(
                'form' => $form ? $form->createView() : null
            )
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

    public function exportCSVAction()
    {
        $articles = $this->getEntityRepository()->selectAll();

        $properties = array(
            'Family' => 'family',
            'SubFamily' => 'subFamily',
            'Code' => 'code',
            'Description' => 'description',
            'Quantity' => 'quantity',
        );

        $separator = ';';
        $line_separator = "\n";

        $engine = $this->container->get('templating');
        $content = $engine->render(
            'SupinfoWebBundle:Client\Article:export.csv.twig',
            array(
                'articles' => $articles,
                'properties' => $properties,
                'separator' => ';',
                'line_separator' => $line_separator,
                'escaping' => array(
                    $separator => ' ',
                    $line_separator => ' '
                )
            )
        );

        return new Response(
            utf8_decode($content),
            200,
            array(
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="export.csv"'
            )
        );
    }

    public function availabilityAction($id)
    {
        $this->fetchEntity(array('id' => $id));

        $results = $this->getEntityRepository()->getAvailability($this->entity);

        return $this->render(
            'SupinfoWebBundle:Client/Article:availability.html.twig',
            array(
                'results' => $results
            )
        );
    }

}