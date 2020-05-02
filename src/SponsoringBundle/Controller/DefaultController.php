<?php

namespace SponsoringBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SponsoringBundle:Default:index.html.twig');
    }
}
