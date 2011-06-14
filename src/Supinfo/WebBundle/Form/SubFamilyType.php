<?php

namespace Supinfo\WebBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SubFamilyType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        // Fields.
        $builder->add('name');

        // Relations.
        $builder->add('family');

        // Collection.
        $builder->add('fields', 'collection', array(
            'type' => new SimpleSubFamilyFieldType(),
            'allow_add' => false,
            'allow_delete' => true,
        ));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Supinfo\WebBundle\Entity\SubFamily',
        );
    }
}