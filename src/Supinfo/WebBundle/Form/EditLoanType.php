<?php

namespace Supinfo\WebBundle\Form;

use Symfony\Component\Form\FormBuilder;

class EditLoanType extends LoanType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        // Fields.
        $builder->add('reason');
        $builder->add('dateStart');
        $builder->add('dateEnd');
    }
}