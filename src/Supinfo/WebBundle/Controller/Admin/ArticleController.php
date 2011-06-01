<?php

namespace Supinfo\WebBundle\Controller\Admin;

use Supinfo\WebBundle\Controller\AdminController;

class ArticleController extends AdminController
{
    protected function getEntityName()
    {
        return 'Article';
    }
}