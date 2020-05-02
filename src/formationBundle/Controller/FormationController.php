<?php


namespace formationBundle\Controller;


use formationBundle\Entity\Formation;
use formationBundle\Entity\participation;
use formationBundle\Form\FormationType;
use formationBundle\Form\PartType;
use formationBundle\Form\RechercheType;
use formationBundle\formationBundle;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FormationController extends Controller
{
    public function accueilAction()
    {
        return $this->render('@formation/Formation/accueil.html.twig');
    }

    public function afficheAction()
    {
        $formations=$this->getDoctrine()->getRepository(Formation::class)->findBy(array(),array('dateDebut'=>'ASC'));
        return $this->render('@formation/Formation/afficheformation.html.twig', array(
            'formations'=>$formations
        ));
    }
    public function createAction(Request $request)
    {
        $formation=new formation();

        $form=$this->createForm(FormationType::class,$formation);

        $form=$form->handleRequest($request);

        if($form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($formation);
            $em->flush();
            return $this->redirectToRoute('formation_Affichage');
        }
        return $this->render('@formation/Formation/ajoutformation.html.twig', array(
            'form'=>$form->createView()
        ));
    }
    public function updateAction (Request $request,$id)
    {

        $em= $this->getDoctrine()->getManager();
        $Formation= $em->getRepository('formationBundle:Formation')->find($id);

        $form=$this->createForm(FormationType::class,$Formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $em= $this->getDoctrine()->getManager();
            $em->persist($Formation);
            $em->flush();

            return $this->redirectToRoute('formation_Affichage');
        }
        return $this->render('@formation/Formation/update.html.twig',
            array("form"=>$form->createView()));

    }
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $formation= $em->getRepository(Formation::class)->find($id);
        $em->remove($formation);
        $em->flush();
        return $this->redirectToRoute("formation_Affichage");
    }
    public function rechercheAction(Request $request)
    {
        $formation= new formation();
        $form= $this->createForm(RechercheType::class,$formation);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $formations= $this->getDoctrine()->getRepository(Formation::class)
                ->findBy(array('description'=>$formation->getDescription()));
        }
        else{
            $formations= $this->getDoctrine()->getRepository(Formation::class)
                ->findAll();
        }
        return $this->render('@formation/Formation/rechercheformation.html.twig',array("form"=>$form->createView(),'formations'=>$formations));

    }
    public function newAction(Request $request)
    {
        $formation = new formation();
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('brochure')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $formation->setBrochureFilename($newFilename);
            }

            // ... persist the $product variable or any other work

            return $this->redirect($this->generateUrl('app_product_list'));
        }

        return $this->render('product/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    public function participerForAction(Request $request)
    {

        $participation = new participation() ;

        $form = $this->createForm(PartType::class,$participation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            // $partFor->setUserId($this->getUser()->getId());

            $em= $this->getDoctrine()->getManager();
            $em->persist($participation);
            $em->flush();
            return $this->redirectToRoute('formation_Affichage');
        }
        return $this->render('@formation/Formation/part.html.twig',
            array("form"=>$form->createView()));
    }

}



