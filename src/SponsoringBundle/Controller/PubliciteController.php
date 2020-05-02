<?php


namespace SponsoringBundle\Controller;


use http\Client\Curl\User;
use SponsoringBundle\Entity\Candidat;
use SponsoringBundle\Entity\Sponsoring;
use SponsoringBundle\Form\SponsoringType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Session\Session;


class PubliciteController extends Controller
{

    public function layoutAction()
    {
        return $this->render('@Sponsoring/Publicite/layout.html.twig');
    }
    public function profilsponsorAction()
    {
        if($this->getUser())
        {
            $user = $this->getUser();
           // echo 'Bienvenue '. $user;

        }
        return $this->render('@Sponsoring/Publicite/profilsponsor.html.twig');
    }
    public function afficheAction()
    {

        $publicites=$this->getDoctrine()->getRepository(Sponsoring::class)->findAll();
        return $this->render('@Sponsoring/Publicite/affichepub.html.twig', array(
            'publicites'=>$publicites
        ));
    }
    public function ajouterAction(Request $request)
    {
        $publication= new Sponsoring();

        $form= $this->createForm(SponsoringType::class,$publication);
        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $file=$publication->getImage();
            $filename=md5(uniqid()).'.'.$file->guessExtension();

            $file->move(
                $this->getParameter('image_directory'), $filename
            );

            $publication->setImage($filename);

            $em= $this->getDoctrine()->getManager();
            $em->persist($publication);
            $em->flush();
            return $this->redirectToRoute("sponsoring_affiche");
        }
        return $this->render("@Sponsoring/Publicite/ajouterpub.html.twig",array("form"=>$form->createView()));
    }
    public function modifierAction(Request $request, $id)
    {
        $em=$this->getDoctrine()->getManager();
        $publicite = $em->getRepository(Sponsoring::class)->find($id);
        if ($request->isMethod('POST')) {
            $publicite->setDescription($request->get('description'));
            $publicite->setType($request->get('type'));
            $publicite->setImage($request->get('image'));
            $em->flush();
            return $this->redirectToRoute('sponsoring_affiche');
        }
        return $this->render('@Sponsoring/Publicite/modifierpub.html.twig', array(
            'pub' => $publicite
        ));
    }
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $publicite= $em->getRepository(Sponsoring::class)->find($id);
        $em->remove($publicite);
        $em->flush();
        return $this->redirectToRoute("sponsoring_affiche");
    }

    public function consulterAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $publicites=$em->getRepository(Sponsoring::class)->findPublicite($id);
        $candidat = $em->getRepository(Candidat::class)->find($id);
        return $this->render('@Sponsoring/Publicite/consulter.html.twig', array(
            'pub'=>$publicites,
            'candidat'=>$candidat
        ));
    }
}