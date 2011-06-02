<?php

namespace Supinfo\WebBundle\Controller\Admin;

use Supinfo\WebBundle\Controller\AdminController;

class ArticleController extends AdminController
{
    protected function getEntityName()
    {
        return 'Article';
    }

    protected function getEntityFormBuilder()
    {
        $builder = parent::getEntityFormBuilder();

        if ($this->entity->getId() === null) {
            $builder->remove('formFieldValues');
        }

        return $builder;
    }

    protected function saveFormEntity()
    {
        $this->entity->checkAndReplaceSubFamilyFields($this->getEntityManager());

        parent::saveFormEntity();
    }
}