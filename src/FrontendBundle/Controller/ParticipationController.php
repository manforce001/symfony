<?php

namespace FrontendBundle\Controller;

use AppBundle\Entity\Evenement;
use AppBundle\Entity\Participation;
use AppBundle\Entity\Publication;
use AppBundle\Form\ParticipationType;
use FrontendBundle\Form\PublicationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;

class ParticipationController extends Controller
{
    public function createAction(  $eventId, Request $request )
    {
        $participation =new Participation();

        $form=$this->createForm(ParticipationType::class,$participation);

        $form=$form->handleRequest($request);

        if($form->isValid()){

            $participation->setUser($this->getUser());
            $event =$this->getDoctrine()->getRepository(Evenement::class)->find($eventId );
            if($event instanceof Evenement){
                if ($event->getNbActuel() >= ($event->getNombreMaxparticipants()) ){

                    return $this->redirectToRoute('participation_add',array('eventId' => $eventId,'error' => 'message erreur'));


                }
            }

            $participation->setEvenement($event);
            $em=$this->getDoctrine()->getManager();
            $event->setNbActuel($event->getNbActuel()+1);
            $em->persist($participation);
            $em->flush();
            return $this->redirectToRoute('publication_add',array('eventId' => $eventId));
        }
        return $this->render('@Frontend/Participation/ajoutparticipation.html.twig', array(
            'form'=>$form->createView()
        ));
    }
}
