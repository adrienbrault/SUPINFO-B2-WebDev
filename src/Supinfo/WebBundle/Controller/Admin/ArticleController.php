<?php

namespace Supinfo\WebBundle\Controller\Admin;

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
        if ($this->entityClone->getId() !== null) {
            $this->getEntityRepository()->checkArticleFieldValues($this->entity);
        }

        parent::saveFormEntity();
    }
}