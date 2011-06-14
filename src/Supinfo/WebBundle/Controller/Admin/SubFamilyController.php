<?php

namespace Supinfo\WebBundle\Controller\Admin;

use Supinfo\WebBundle\Entity\SubFamilyField;

class SubFamilyController extends AdminController
{
    protected function getEntityName()
    {
        return 'SubFamily';
    }

    protected $fieldsClone;

    protected function createEntityForm()
    {
        $this->fieldsClone = $this->entity->getFields()->toArray();
        parent::createEntityForm();
    }

    protected function saveFormEntity()
    {
        // orphanRemoval does not work with YAML mapping. This is a workaround.
        $fieldsDiff = array_diff(
            $this->fieldsClone,
            $this->entity->getFields()->toArray()
        );

        $em = $this->getEntityManager();
        foreach ($fieldsDiff as $field) {
            if ($em->contains($field)) {
                $em->remove($field);
            }
        }

        parent::saveFormEntity();
    }

    public function editNewFieldAction()
    {
        $this->fetchEntity();

        $field = new SubFamilyField();
        $field->setSubFamily($this->entity);
        $field->setName('Unnamed');

        $em = $this->getEntityManager();
        $em->persist($field);
        $em->flush();

        $this->getEntityManager()
            ->getRepository('SupinfoWebBundle:SubFamilyField')
            ->createSubFamilyFieldValues($field);

        return $this->redirectToEdit();
    }

}