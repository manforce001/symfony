<?php

namespace EvenementBundle\Controller;

 use EvenementBundle\Entity\Evenement;
 use Symfony\Bundle\FrameworkBundle\Controller\Controller;
 use Symfony\Component\HttpFoundation\JsonResponse;
 use Symfony\Component\HttpFoundation\Request;
 use Symfony\Component\Validator\Constraints\Date;

 class EvenementFrontController extends Controller
{
    public  function showBycategoryAction($categorie, Request $request ){
        $evenements=$this->getDoctrine()->getRepository(Evenement::class)->getEventByCategory($categorie);
        return $this->render('@Evenement/frontend/Evenement/afficheevenement.html.twig', array(
            'evenements'=>$evenements
        ));
    }

     public  function showoneEvenementAction($id, Request $request ){
         $evenement =$this->getDoctrine()->getRepository(Evenement::class)->find($id);
         return $this->render('@Evenement/frontend/Evenement/showoneEvenement.html.twig', array(
             'evenement'=>$evenement
         ));
     }
     public  function showoneEvenementCalenderAction( Request $request ){

         return $this->render('@Evenement/frontend/Evenement/calender.html.twig', array(

         ));
     }

     public function getEventsJsonAction()
     {
         $evenements = $this->getDoctrine()->getRepository(Evenement::class)->findAll();

         $resultat = array();

         foreach ($evenements as $event) {
             $today = new \DateTime();
             $res = array(
                 'id' => $event->getId(),
                 'start' => $event->getDateDebut()->format('Y-m-d'),
                 'end' => $event->getDateFin()->format('Y-m-d'),
                 'title' => $event->getTitle(),
                 'color'=> $event->getDateFin() > $today ? '#0000FF' : '#FF0000'
             );
             $resultat[] = $res;
         }

         return new JsonResponse(($resultat));

     }


}
