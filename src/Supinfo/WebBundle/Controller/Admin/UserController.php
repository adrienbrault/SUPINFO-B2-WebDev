<?php

namespace Supinfo\WebBundle\Controller\Admin;

use Supinfo\WebBundle\Controller\AdminController;

class UserController extends AdminController
{
    protected function getEntityName()
    {
        return 'User';
    }



    protected function saveFormEntity()
    {
        if ($this->entity->getPlainPassword() != null) {
            // The password has changed, we have to generate a new salt and encode the password.

            $encoderFactory = $this->get('security.encoder_factory');
            $encoder = $encoderFactory->getEncoder($this->entity);

            $newSalt = hash('sha512', microtime(true).rand());
            $encodedPassword = $encoder->encodePassword($this->entity->getPlainPassword(), $newSalt);

            $this->entity->setPassword($encodedPassword);
            $this->entity->setSalt($newSalt);
        }

        parent::saveFormEntity();
    }
}