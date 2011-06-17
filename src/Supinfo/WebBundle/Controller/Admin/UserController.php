<?php

namespace Supinfo\WebBundle\Controller\Admin;

use Symfony\Component\Form\FormError;

class UserController extends AdminController
{
    protected function getEntityName()
    {
        return 'User';
    }

    protected function getEntityFormBuilder()
    {
        $builder = parent::getEntityFormBuilder();

        if ($this->entity->getId() === null) {
            $builder->get('plainpassword')->setRequired(true);
        }

        return $builder;
    }

    protected function entityFormIsValid()
    {
        if ($this->entity->getPassword() === null && strlen($this->entity->getPlainPassword()) < 1) {
            $this->entityForm->get('plainpassword')->addError(new FormError('The password cannot be blank.'));

            return false;
        }

        if ($this->entity->getUsername() != $this->entityClone->getUsername()
            && !$this->getEntityRepository()->usernameIsAvailable($this->entity->getUsername())) {
            $this->entityForm->get('username')->addError(new FormError('Username not available.'));

            return false;
        }

        return $this->entityForm->isValid();
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

    public function deleteAction()
    {
        $this->fetchEntity();

        if ($this->get('security.context')->getToken()->getUser() == $this->entity) {
            $this->get('session')->setFlash('notice', 'You can delete yourself.');
            return $this->redirectToList();
        }

        $em = $this->getEntityManager();
        $em->remove($this->entity);
        $em->flush();

        $this->get('session')->setFlash('notice', $this->getEntityName().' successfully deleted.');

        // Redirect to the list.
        return $this->redirectToList();
    }
}