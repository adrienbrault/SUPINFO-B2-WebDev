<?php

namespace Supinfo\WebBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        // Fields.
        $builder->add('username');
        $builder->add('plainpassword', 'password', array('required' => false));
        $builder->add('firstName');
        $builder->add('lastName');
        $builder->add('telephone');
        $builder->add('function');
        $builder->add('address');
        $builder->add('type', 'choice', array('choices' => $this->getTypeChoices()));

        // Relations.
        $builder->add('structure');
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Supinfo\WebBundle\Entity\User',
        );
    }

    protected function getTypeChoices()
    {
        $defaultOptions = $this->getDefaultOptions(array());

        return call_user_func(array(
            $defaultOptions['data_class'],
            'getTypes'
        ));
    }
}