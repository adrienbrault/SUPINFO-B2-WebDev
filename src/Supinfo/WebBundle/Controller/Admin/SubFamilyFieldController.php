<?php

namespace Supinfo\WebBundle\Controller\Admin;

use Supinfo\WebBundle\Controller\AdminController;

class SubFamilyFieldController extends AdminController
{
    protected function getEntityName()
    {
        return 'SubFamilyField';
    }

    protected function saveFormEntity()
    {
        parent::saveFormEntity();

        if ($this->entity->getSubFamily() != $this->entityClone->getSubFamily()) {
            $this->getEntityRepository()->createSubFamilyFieldValues($this->entity);
        }
    }
}