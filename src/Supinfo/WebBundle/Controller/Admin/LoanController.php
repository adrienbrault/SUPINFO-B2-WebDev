<?php

namespace Supinfo\WebBundle\Controller\Admin;

class LoanController extends AdminController
{
    protected function getEntityName()
    {
        return 'Loan';
    }

    public function listAction()
    {
        return $this->redirect(
            $this->generateUrl(
                'client_Loan_list'
            )
        );
    }
}