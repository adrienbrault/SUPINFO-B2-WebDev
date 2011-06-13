<?php

namespace Supinfo\WebBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class LoanListFiltersType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('filters', 'choice', array(
            'choices' => $this->getFiltersChoices(),
            'multiple' => true,
            'expanded' => true
        ));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Supinfo\WebBundle\Entity\LoanListFilters',
        );
    }

    protected function getFiltersChoices()
    {
        $defaultOptions = $this->getDefaultOptions(array());

        return call_user_func(array(
            $defaultOptions['data_class'],
            'getFiltersChoices'
        ));
    }
}