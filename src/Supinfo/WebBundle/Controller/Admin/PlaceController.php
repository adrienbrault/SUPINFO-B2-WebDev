<?php

namespace Supinfo\WebBundle\Controller\Admin;

use Supinfo\WebBundle\Controller\AdminController;

class PlaceController extends AdminController
{
    protected function getEntityName()
    {
        return 'Place';
    }
}