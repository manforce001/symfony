<?php

namespace BackendBundle\Controller;

use AppBundle\Entity\Evenement;
use AppBundle\Entity\Publication;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PublicationController extends Controller
{
    public function afficheAction(Request $request)
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $paginator  = $this->get('knp_paginator');

        $dql   = "SELECT a FROM AppBundle:Publication a ";
        $query = $em->createQuery($dql);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        // parameters to template
        return $this->render('@Backend/Publication/affichepublication.html.twig', ['pagination' => $pagination]);
    }

    public function validateAction($id, Request $request)
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $pub =$this->getDoctrine()->getRepository(Publication::class)->find($id);

        if ($pub instanceof  Publication){
            $pub->setIsValid(true);

            $em->persist($pub);
            $em->flush();
        }

        return $this->redirectToRoute('publicattion_list');


    }

    public function blockAction($id, Request $request)
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $pub =$this->getDoctrine()->getRepository(Publication::class)->find($id);

        if ($pub instanceof  Publication){
            $pub->setIsBlocked(true);
            $em->persist($pub);
            $em->flush();
        }

        return $this->redirectToRoute('publicattion_list');


    }


}
