<?php

namespace Supinfo\WebBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        // Fields.
        $builder->add('displayId', 'text', array('read_only' => true));
        $builder->add('description');
        $builder->add('code');
        $builder->add('state', 'choice', array('choices' => $this->getStateChoices()));
        $builder->add('quantity');

        // Relations.
        $builder->add('place');
        $builder->add('subFamily');

        $builder->add('fieldValues', 'collection', array(
            'type' => new SubFamilyFieldValueType()
        ));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Supinfo\WebBundle\Entity\Article',
        );
    }

    protected function getStateChoices()
    {
        $defaultOptions = $this->getDefaultOptions(array());
        
        return call_user_func(array(
            $defaultOptions['data_class'],
            'getStates'
        ));
    }
}