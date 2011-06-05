<?php

namespace Supinfo\WebBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class NewLoanType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        // Fields.
        $builder->add('reason');
        $builder->add('dateStart');
        $builder->add('dateEnd');
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Supinfo\WebBundle\Entity\Loan',
        );
    }
}