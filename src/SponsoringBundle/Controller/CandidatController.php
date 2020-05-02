<?php


namespace SponsoringBundle\Controller;


use SponsoringBundle\Entity\Candidat;
use SponsoringBundle\Form\RechercheType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CandidatController extends Controller
{
    public function rechercheCandidatAction(Request $request)
    {
        $candidat= new Candidat();
        $form= $this->createForm(RechercheType::class,$candidat);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $candidats= $this->getDoctrine()->getRepository(Candidat::class)
                ->findBy(array('nom'=>$candidat->getNom()));
        }
        else{
            $candidats= $this->getDoctrine()->getRepository(Candidat::class)
                ->findAll();
        }
        return $this->render("@Sponsoring/Candidat/recherchecandidat.html.twig",array("form"=>$form->createView(),'candidats'=>$candidats));

    }

}