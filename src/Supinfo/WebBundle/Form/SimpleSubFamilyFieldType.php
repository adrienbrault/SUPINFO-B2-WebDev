<?php

namespace Supinfo\WebBundle\Form;

use Symfony\Component\Form\FormBuilder;

class SimpleSubFamilyFieldType extends SubFamilyFieldType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        // Fields.
        $builder->add('name');
    }
}