<?php

namespace formationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('formationBundle:Default:index.html.twig');
    }
}
