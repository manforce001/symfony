<?php


namespace SponsoringBundle\Controller;


use SponsoringBundle\Entity\Demandesponsoring;
use SponsoringBundle\Form\DemandesponsoringType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DemandeController extends Controller
{
    public function affichedemandeAction()
    {
        $demandes=$this->getDoctrine()->getRepository(Demandesponsoring::class)->findAll();
        return $this->render('@Sponsoring/Demande/affichedemande.html.twig', array(
            'demandes'=>$demandes
        ));
    }
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $demande= $em->getRepository(Demandesponsoring::class)->find($id);
        $em->remove($demande);
        $em->flush();
        return $this->redirectToRoute("affiche_dem");
    }
    public function ajoutdemandeAction(Request $request)
    {
        $demande= new DemandeSponsoring();

        $form= $this->createForm(DemandesponsoringType::class,$demande);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $em= $this->getDoctrine()->getManager();
            $em->persist($demande);
            $em->flush();
            return $this->redirectToRoute("affiche_dem");
        }
        return $this->render("@Sponsoring/Demande/ajouterdemande.html.twig",array("form"=>$form->createView()));
    }
}