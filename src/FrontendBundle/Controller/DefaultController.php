<?php

namespace FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('frontend/index.html.twig', [
        ]);
    }


    public function aboutAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('frontend/about.html.twig', [
        ]);
    }

    public function contactAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('frontend/contact.html.twig', [
        ]);
    }



}
