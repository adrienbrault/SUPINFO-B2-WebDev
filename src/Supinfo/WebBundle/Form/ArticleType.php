<?php

namespace Supinfo\WebBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        // Fields.
        $this->add('code');
        $this->add('description');
        $this->add('state');
        $this->add('quantity');

        // Relations.
        $this->add('place');
        $this->add('subFamily');
        $this->add('fieldValues');
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Supinfo\WebBundle\Entity\Article',
        );
    }
}