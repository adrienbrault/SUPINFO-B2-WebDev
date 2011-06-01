<?php

namespace Supinfo\WebBundle\Controller\Admin;

use Supinfo\WebBundle\Controller\AdminController;

class UserController extends AdminController
{
    protected function getEntityName()
    {
        return 'User';
    }
}