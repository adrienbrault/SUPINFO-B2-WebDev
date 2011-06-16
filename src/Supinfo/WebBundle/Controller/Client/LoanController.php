<?php

namespace Supinfo\WebBundle\Controller\Client;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Supinfo\WebBundle\Entity\Loan;
use Supinfo\WebBundle\Entity\Article;
use Supinfo\WebBundle\Entity\ArticleLoan;
use Supinfo\WebBundle\Entity\User;
use Supinfo\WebBundle\Form\NewLoanType;
use Supinfo\WebBundle\Form\EditLoanType;
use Supinfo\WebBundle\Form\LoanAddArticleType;
use Supinfo\WebBundle\Entity\LoanListFilters;
use Supinfo\WebBundle\Form\LoanListFiltersType;

class LoanController extends EntityController
{

    public function getEntityName()
    {
        return 'Loan';
    }



    public function newAction() {
        $this->entity = $this->getEntityRepository()->newEntity();

        $formBuilder = $this->get('form.factory')
            ->createBuilder(new NewLoanType(), $this->entity);

        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $userRepository = $this->getEntityManager()->getRepository('SupinfoWebBundle:User');

            $formBuilder->add('user', 'entity', array(
                'query_builder' => $userRepository->selectClientsQB(),
                'class' => 'Supinfo\WebBundle\Entity\User'
            ));
        }

        $form = $formBuilder->getForm();

        $userInSession = $this->get('security.context')->getToken()->getUser();
        if ($userInSession instanceof User
            && $this->get('security.context')->isGranted('ROLE_CLIENT')) {
            $this->entity->setUser($userInSession);
        }

        $request = $this->get('request');
        if ($request->getMethod() == 'POST' && $request->get($form->getName())) {
            $form->bindRequest($request);

            // Custom validation.
            if ($this->entity->getDateStart() >= $this->entity->getDateEnd()) {
                $form->addError(new FormError('DateEnd must be after DateStart.'));
            }

            if (!$this->entity->getUser() instanceof User) {
                $form->addError(new FormError('You must choose a database user to create a loan.'));
            }

            if ($form->isValid()) {
                $this->getEntityManager()->persist($this->entity);
                $this->getEntityManager()->flush();

                $this->get('session')->setFlash('notice', 'Loan successfully created.');

                return new RedirectResponse($this->generateUrl(
                    'client_Loan_edit',
                    array(
                         'id' => $this->entity->getId()
                    )
                ));
            }
        }

        return $this->render(
            'SupinfoWebBundle:Client\Loan:new.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    public function editAction($id) {
        $this->fetchEntity(array('id' => $id));

        if (!$this->get('security.context')->isGranted('ROLE_ADMIN')
            && $this->entity->getUser() != $this->get('security.context')->getToken()->getUser()) {
            throw new AccessDeniedException('You must be the owner of a Loan to edit it.');
        }

        $formBuilder = $this->get('form.factory')
            ->createBuilder(new EditLoanType(), $this->entity);

        $userRepository = $this->getEntityManager()->getRepository('SupinfoWebBundle:User');
        $formBuilder->add('user', 'entity', array(
            'query_builder' => $userRepository->selectClientsQB(),
            'class' => 'Supinfo\WebBundle\Entity\User',
            'read_only' => !$this->get('security.context')->isGranted('ROLE_ADMIN')
        ));

        $form = $formBuilder->getForm();

        $formAddArticle = $this->get('form.factory')
            ->createBuilder(new LoanAddArticleType())
            ->getForm();

        $request = $this->get('request');
        if ($request->getMethod() == 'POST' && $request->get($form->getName())) {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $this->getEntityManager()->flush();

                $this->get('session')->setFlash('notice', 'Loan successfully edited.');

                return new RedirectResponse($this->generateUrl('client_Loan_edit', array('id' => $this->entity->getId())));
            }
        } else if ($request->getMethod() == 'POST' && $request->get($formAddArticle->getName())) {
            $formAddArticle->bindRequest($request);

            if ($formAddArticle->isValid()) {
                $articleId = $formAddArticle->get('id')->getData();
                if (preg_match('/^1([0-9]{4})$/', $articleId)) {
                    $articleId = substr($articleId, 1);
                }

                $article = $this->getEntityManager()
                    ->getRepository('SupinfoWebBundle:Article')
                    ->selectOneById($articleId);

                if (!$article) {
                    $formAddArticle->addError(new FormError('Article does not exists.'));
                } else {
                    $articleLoanCount = $this->getEntityManager()
                        ->getRepository('SupinfoWebBundle:ArticleLoan')
                        ->countById($article->getId(), $this->entity->getId());

                    if ($articleLoanCount > 0) {
                        $formAddArticle->addError(new FormError('This article has already been added.'));
                    } else {
                        $articleLoan = new ArticleLoan();
                        $articleLoan->setArticle($article);
                        $articleLoan->setLoan($this->entity);
                        $articleLoan->setDateStart($this->entity->getDateStart());
                        $articleLoan->setDateEnd($this->entity->getDateEnd());

                        $this->getEntityManager()->persist($articleLoan);
                        $this->getEntityManager()->flush();

                        $this->get('session')->setFlash('notice', 'Article added.');

                        return new RedirectResponse($this->generateUrl(
                            'client_Loan_edit',
                            array('id' => $this->entity->getId())
                        ));
                    }
                }
            }
        }

        return $this->render(
            'SupinfoWebBundle:Client\Loan:edit.html.twig',
            array(
                'form' => $form->createView(),
                'formAddArticle' => $formAddArticle->createView(),
            )
        );
    }
    
    public function deleteArticleLoanAction($loanId, $articleId)
    {
        $entityRepository = $this->getEntityManager()->getRepository('SupinfoWebBundle:ArticleLoan');

        $articleLoan = $entityRepository->selectOneByIds($articleId, $loanId);

        if (!$articleLoan) {
            throw $this->createNotFoundException();
        }

        if (!$this->get('security.context')->isGranted('ROLE_ADMIN')
            && $this->entity->getUser() != $this->get('security.context')->getToken()->getUser()) {
            throw new AccessDeniedException('You must be the owner of a Loan to edit it.');
        }

        $this->getEntityManager()->remove($articleLoan);
        $this->getEntityManager()->flush();

        $this->get('session')->setFlash('notice', 'Article successfully removed from Loan.');

        return $this->redirect($this->generateUrl('client_Loan_edit', array('id' => $loanId)));
    }
    
    public function listAction($filters, $page)
    {
        // Managing filters.
        $loanListFilters = new LoanListFilters($filters);

        $filtersForm = $this->get('form.factory')
            ->createBuilder(new LoanListFiltersType(), $loanListFilters)
            ->getForm();

        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $filtersForm->bindRequest($request);

            if ($filtersForm->isValid()) {
                return $this->redirect($this->generateUrl('client_Loan_list', array('filters' => $loanListFilters->getFiltersURI())));
            }
        }

        $this->initPaginator(array(
            'current_page' => $page,
            'select_qb' => $this->getEntityRepository()->selectQBWithFilters($loanListFilters->getFilters()),
            'route_params' => array('filters' => $loanListFilters->getFiltersURI()),
            'results_per_page' => 20
        ));

        $this->entities = $this->paginator->getCurrentPageResults();

        return $this->render(
            'SupinfoWebBundle:Client\Loan:list.html.twig',
            array(
                'filtersForm' => $filtersForm->createView()
            )
        );
    }

    public function viewAction($id)
    {
        $this->fetchEntity(array('id' => $id));

        return $this->render(
            'SupinfoWebBundle:Client\Loan:view.html.twig'
        );
    }

    public function printAction($id)
    {
        $this->fetchEntity(array('id' => $id));

        return $this->render(
            'SupinfoWebBundle:Client\Loan:print.html.twig'
        );
    }

}