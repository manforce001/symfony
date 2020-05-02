<?php

namespace EvenementBundle\Controller;

use EvenementBundle\Entity\Evenement;
use EvenementBundle\Entity\Publication;
use EvenementBundle\Form\PublicationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PublicationFrontendController extends Controller
{


    public function afficheByeventAction($idEvent,Request $request)
    {
        $evenement =$this->getDoctrine()->getRepository(Evenement::class)->find($idEvent);

        $publications=$this->getDoctrine()->getRepository(Publication::class)->findBy([
            'evenement' => $evenement
        ]);
        return $this->render('@Evenement/frontend/Publication/affichepublication.html.twig', array(
            'publications'=>$publications
        ));
    }


    public function afficheAction()
    {
        $publications=$this->getDoctrine()->getRepository(Publication::class)->findBy([
            'isValid' => true
        ]);
        return $this->render('@Evenement/frontend/Publication/affichepublication.html.twig', array(
            'publications'=>$publications
        ));
    }

    public  function showonePublicationAction($id, Request $request ){
        $publication =$this->getDoctrine()->getRepository(Publication::class)->find($id);
        return $this->render('@Evenement/frontend/Publication/showonePublication.html.twig', array(
            'publication'=>$publication
        ));
    }

    public function createAction($eventId, Request $request)
    {
        $publication=new publication();
        $publication->setNbdislikeJurey(0);
        $publication->setNbdislikeCoatch(0);
        $publication->setNbLikeCoatch(0);
        $publication->setNbLikejurey(0);
        $form=$this->createForm(PublicationType::class,$publication);

        $form=$form->handleRequest($request);

        if($form->isValid()){
            $event =$this->getDoctrine()->getRepository(Evenement::class)->find($eventId);

            // get user publications
            $publications = $this->getDoctrine()->getRepository(Publication::class)->findBy([
                'User' => $this->getUser(),
                'evenement' => $event
            ]);
            if (count($publications)>=3){
                return $this->render('@Evenement/frontend/Publication/ajoutpublication.html.twig', array(
                    'form'=>$form->createView(),
                    'error' => 'désolé vous avez dépassé votre quota des éléments partagés'
                ));
            }

            $image = $form->get('fileUpload')->getData();
            if ($image) {
                 // this is needed to safely include the file name as part of the URL

                $newFilename =  uniqid() . '.' . $image->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $dir = '';

                    $contenu = $publication->getContenu();
                    switch ($contenu) {
                        case 'image':
                            $dir = $this->getParameter('publication_image_directory');
                            break;
                        case 'video':
                            $dir = $this->getParameter('publication_video_directory');
                            break;
                    }


                    $image->move(
                        $dir,
                        $newFilename
                    );
                    $publication->setFile($newFilename);
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

            }
            $publication->setUser($this->getUser());
             $publication->setEvenement($event);
            $em=$this->getDoctrine()->getManager();
            $em->persist($publication);
            $em->flush();
            return $this->redirectToRoute('publication_sucess');
        }
        return $this->render('@Evenement/frontend/Publication/ajoutpublication.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $publication=  $em->getRepository('EvenementBundle:Publication')->findEntitiesByString($requestString);
        if(!$publication) {
            $result = "publication non trouvé :( ";
        } else {
            $html = $this->renderView('@Evenement/frontend/Publication/search.html.twig', array(
                'publications'=> $publication

            ));
            $result=  $html ;
        }
        header_remove();
        return new Response(($result));
    }

    public function successAction(){
        return $this->render('@Evenement/frontend/Publication/success_publication.html.twig', array(
         ));
    }



}
