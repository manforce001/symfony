<?php


namespace formationBundle\Controller;


use formationBundle\Entity\conseil;
use formationBundle\Form\conseilType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ConseilController extends Controller
{
    public function afficheAction()
    {
        $conseils=$this->getDoctrine()->getRepository(conseil::class)->findAll();
        return $this->render('@formation/Conseil/afficheconseil.html.twig', array(
            'conseils'=>$conseils
        ));
    }
    public function createAction(Request $request)
    {
        $conseil=new conseil();

        $form=$this->createForm(conseilType::class,$conseil);

        $form=$form->handleRequest($request);
        if ($form->isSubmitted()){
            $file=$conseil->getImage();
            $filename=md5(uniqid()).'.'.$file->guessExtension();

            $file->move(
                $this->getParameter('image_directory'), $filename
            );

            $conseil->setImage($filename);


            $em=$this->getDoctrine()->getManager();
            $em->persist($conseil);
            $em->flush();
            return $this->redirectToRoute('conseil_Affichage');
        }
        return $this->render('@formation/Conseil/ajoutconseil.html.twig', array(
            'form'=>$form->createView()
        ));
    }
}