<?php

namespace EvenementBundle\Controller;

use EvenementBundle\Entity\Evenement;
use EvenementBundle\Entity\Publication;
use EvenementBundle\Form\EvenementEditType;
use EvenementBundle\Form\EvenementType;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class EvenementController extends Controller
{
    public function afficheAction(Request $request)
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $paginator  = $this->get('knp_paginator');

        $dql   = "SELECT a FROM EvenementBundle:Evenement a ";
        $query = $em->createQuery($dql);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        // parameters to template
        return $this->render('@Evenement/backend/Evenement/afficheevenement.html.twig', ['pagination' => $pagination]);
    }
    public function createAction(Request $request)
    {
        $evenement=new Evenement();

        $form=$this->createForm(EvenementType::class,$evenement);

        $form=$form->handleRequest($request);

        if($form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $image = $form->get('imageFile')->getData();
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);

                $newFilename = $originalFilename . '-' . uniqid() . '.' . $image->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $image->move(
                        $this->getParameter('evenemnts_image_directory'),
                        $newFilename
                    );
                    $evenement->setImagepath($newFilename);
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            }
            $em->persist($evenement);
            $em->flush();
            return $this->redirectToRoute('evenement_affiche');
        }
        return $this->render('@Evenement/backend/Evenement/ajouterevenement.html.twig', array(
            'form'=>$form->createView()
        ));
    }
    public function updateAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $evenement = $em->getRepository(Evenement::class)->find($id);

        $publications = $em->getRepository(Publication::class)->findBy([
            'evenement' => $evenement
        ]);

        if ($publications != null ){
            return $this->redirectToRoute("evenement_affiche",[
                'error' => 'je ne peux pas modifier cet evenement car il ya deja des personnes qui y participent '
            ]);
        }


        $form=$this->createForm(EvenementEditType::class,$evenement);
        $form=$form->handleRequest($request);

        if ($request->isMethod('POST')) {





            $image = $form->get('imageFile')->getData();
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);

                $newFilename = $originalFilename.'-'.uniqid().'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $image->move(
                        $this->getParameter('evenemnts_image_directory'),
                        $newFilename
                    );
                    $evenement->setImagepath($newFilename);
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }


            }


            $em->persist($evenement);

            $em->flush();
            return $this->redirectToRoute('evenement_affiche');
        }

        return $this->render('@Evenement/backend/Evenement/modifierevenement.html.twig', array(
            'form'=>$form->createView(),
            'image' =>$evenement->getImagePath()

        ));
    }
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $evenement= $em->getRepository(Evenement::class)->find($id);
        try{
            $em->remove($evenement);
            $em->flush();
        }catch (DBALException $exception){
            return $this->redirectToRoute("evenement_affiche",[
                'error' => 'Je ne peux pas supprimer cet evenement car il ya deja des personnes qui y participent '
            ]);
        }

        return $this->redirectToRoute("evenement_affiche");
    }


    public function updateEventStatusAction(Request $request,$id,$etat)
    {
        $em = $this->getDoctrine()->getManager();

        $event = $this->getDoctrine()->getRepository(Evenement::class)->find($id);

        $event->setIsPublic($etat)
;
        $em->persist($event);
        $em->flush();
        return new JsonResponse();


    }
}
