<?php

namespace Supinfo\WebBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        // Fields.
        $this->add('username');
        $this->add('password');
        $this->add('firstName');
        $this->add('lastName');
        $this->add('telephone');
        $this->add('function');
        $this->add('address');

        // Relations.
        $this->add('structure');
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Supinfo\WebBundle\Entity\User',
        );
    }
}