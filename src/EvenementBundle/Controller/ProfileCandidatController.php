<?php

namespace EvenementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProfileCandidatController extends Controller
{
    public function profileAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@Evenement/frontend/Profile/profile.html.twig', [
        ]);
    }
}
