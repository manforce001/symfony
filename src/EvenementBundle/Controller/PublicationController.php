<?php

namespace EvenementBundle\Controller;

use EvenementBundle\Entity\Evenement;
use EvenementBundle\Entity\Publication;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

class PublicationController extends Controller
{
    public function afficheAction(Request $request)
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $paginator  = $this->get('knp_paginator');

        $dql   = "SELECT a FROM EvenementBundle:Publication a ";
        $query = $em->createQuery($dql);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        // parameters to template
        return $this->render('@Evenement/backend/Publication/affichepublication.html.twig', ['pagination' => $pagination]);
    }

    public function validateAction($id, Request $request)
    {
        $em    = $this->get('doctrine.orm.entity_manager'); //nààyet service de bd
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

        // get user blocked pub number

        $publications = $this->getDoctrine()->getRepository(Publication::class)->findBy([
            'isBlocked' => true,
            'User' => $pub->getUser()
        ]);

    // if (count($publications) >= 3){
            $this->sendMail($pub->getUser());
      //  }


        return $this->redirectToRoute('publicattion_list');


    }


    public function sendMail(User $user ){
        $message = (new \Swift_Message('bloquage'))//component dans symfony
            ->setFrom('admin@example.com')//min àned shkoun
            ->setTo('khawla.benmansour@esprit.tn') //$user->getEmail()
            ->setBody(
                 'Attention! votre compte sera bloquées  ',
                'text/html'
            )

            // you can remove the following code if you don't define a text version for your emails

        ;
        $mailer = $this->get('mailer');
        $mailer->send($message);
        return true;
    }
}
