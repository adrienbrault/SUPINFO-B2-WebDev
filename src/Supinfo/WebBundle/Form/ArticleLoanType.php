<?php

namespace Supinfo\WebBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ArticleLoanType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        // Fields.
        $builder->add('quantity');
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Supinfo\WebBundle\Entity\ArticleLoan',
        );
    }
}