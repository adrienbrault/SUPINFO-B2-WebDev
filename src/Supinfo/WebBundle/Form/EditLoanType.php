<?php

namespace Supinfo\WebBundle\Form;

use Symfony\Component\Form\FormBuilder;

class EditLoanType extends LoanType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('displayId', 'text', array('read_only' => true));

        // Fields.
        $builder->add('reason');
        $builder->add('dateStart');
        $builder->add('dateEnd');

        // Embed.
        $builder->add('articlesLoan', 'collection', array('type' => new ArticleLoanType()));
    }
}