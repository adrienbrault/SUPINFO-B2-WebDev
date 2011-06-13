<?php

namespace Supinfo\WebBundle\Controller\Admin;

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