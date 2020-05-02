<?php

namespace UserBundle\Controller;

use SponsoringBundle\Entity\Sponsoring;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use UserBundle\Entity\User;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@User/Default/index.html.twig');
    }
    public function AllAction()
    {

            $tasks = $this->getDoctrine()->getManager()
                ->getRepository(User::class)
                ->findAll();
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($tasks);

                        return new JsonResponse($formatted);
    }
    public function findAction($id)
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository(User::class)
            ->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }
    public function findMailAction($password, $mail)
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository(User::class)
            ->findBy(array('password'=>$password, 'email'=>$mail));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }
    public function updateMailAction( $id,$nom,$prenom, $tel ,$date,$password)
    {
        $em=$this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)
            ->find($id);
            $user->setNom($nom);
            $user->setPrenom($prenom);
            $user->setTel($tel);
            $user->SetImage($date);
            $user->setPassword($password);
            $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }
    public function updateMail1Action( $id)
    {
        $userManager = $this->get('fos_user.user_manager');
        $em=$this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)
            ->find($id);
        $user->addRole("ROLE_ADMIN");
        $userManager->updateUser($user);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }




    public function adduserAction($nb,$username,$mail,$nom,$prenom,$tel,$date,$role,$password)
    {
        $userManager = $this->get('fos_user.user_manager');

        $em = $this->getDoctrine()->getManager();
        $user = new User();

        $user->setUsernameCanonical("hhh");
        $user->setUsername($username);
        $user->setEmail($mail);
        $user->setEmailCanonical("hhhh");
        $user->setEnabled($nb);
        $user->setSalt($nb);
        $user->setPassword($password);
        $user->setLastLogin(new \DateTime());
        $user->setConfirmationToken($nb);
        $user->setPasswordRequestedAt(new \DateTime());
        //$user->setRoles("a:1:{i:0;s:13:\"ROLE_CANDIDAT\";}");
        $user->addRole($role);
        $userManager->updateUser($user);
        $user->setNom($nom);
        $user->setPrenom($prenom);
        $user->setTel($tel);
        $user->setImage($date);
        $user->setMaill($mail);



        $em->persist($user);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);

    }
}



