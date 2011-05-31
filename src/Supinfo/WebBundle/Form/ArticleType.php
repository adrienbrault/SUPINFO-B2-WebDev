<?php

namespace Supinfo\WebBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        // Fields.
        $builder->add('code');
        $builder->add('description');
        $builder->add('state');
        $builder->add('quantity');

        // Relations.
        $builder->add('place');
        $builder->add('subFamily');
        $builder->add('fieldValues');
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Supinfo\WebBundle\Entity\Article',
        );
    }
}