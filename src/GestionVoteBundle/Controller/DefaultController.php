<?php

namespace GestionVoteBundle\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use EvenementBundle\Entity\Publication;
use GestionPublicationBundle\Entity\VoteCoatch;
use GestionPublicationBundle\Entity\VoteCotchNegative;
use GestionPublicationBundle\Entity\VoteJureyDilike;
use GestionPublicationBundle\Entity\VoteJureyLike;
use GestionVoteBundle\Entity\Coatch;
use GestionVoteBundle\Entity\Jurey;
use GestionVoteBundle\Form\CoatchType;
use GestionVoteBundle\Form\JureyType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GestionVoteBundle:Default:index.html.twig');
    }
    public function ajoutJureyAction(Request $request)
    {
        $user = $this->getUser()->getemail();

        $jurey =new Jurey();
        $jurey->setEmail($user);
        $form=$this->createForm(JureyType::class,$jurey);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($jurey);
            $em->flush();
          //  return $this->redirectToRoute('affiche_patient');
        }

        return $this->render('@GestionVote/Jurey/addJurey.html.twig',
            array('form'=>$form->createView(), "user" => $user));
    }
    public function ajoutCoatchAction(Request $request)
    {
        $user = $this->getUser()->getemail();

        $coatch =new Coatch();
        $coatch->setEmail($user);
        $form=$this->createForm(CoatchType::class,$coatch);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($coatch);
            $em->flush();
            //  return $this->redirectToRoute('affiche_patient');
        }

        return $this->render('@GestionVote/Coatch/addCoatch.html.twig',
            array('form'=>$form->createView(), "user" => $user));
    }




    /*            administration  gestion de vote         */

    /*meilleur like pour jurey*/
    public function listeMeilleurLikeAction()
    {
        $em=$this->getDoctrine()->getManager();
        $repository = $em->getRepository(Publication::class);
        $articles = $repository->findBy([], ['nbLikejurey' => 'desc']);

        return $this->render('GestionVoteBundle:admin:meilleurLikeJurey.html.twig',array('articles'=>$articles));
    }
    /*imprime pdf meilleur like pour jurey*/
    public function PdflisteMeilleurLikeAction()
    {
        $em=$this->getDoctrine()->getManager();
        $repository = $em->getRepository(Publication::class);
        $articles = $repository->findBy([], ['nbLikejurey' => 'desc']);
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $user=0;

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('GestionVoteBundle:admin:meilleurLikeJurey.html.twig',array('articles'=>$articles));

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);



        return $this->render('GestionVoteBundle:admin:meilleurLikeJurey.html.twig',array('articles'=>$articles));
    }
    /* meilleur dislike pour jurey*/
    public function listeMeilleurdisLikeAction()
    {
        $em=$this->getDoctrine()->getManager();
        $repository = $em->getRepository(Publication::class);
        $articles = $repository->findBy([], ['nbdislikejurey' => 'desc']);


        return $this->render('GestionVoteBundle:admin:meilleurDislikeJurey.html.twig',array('articles'=>$articles));
    }
    /*imprime pdf meilleur dislike pour jurey */
    public function PdflisteMeilleurdisLikeAction()
    {
        $em=$this->getDoctrine()->getManager();
        $repository = $em->getRepository(Publication::class);

        $articles = $repository->findBy([], ['nbdislikejurey' => 'desc']);
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $user=0;

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('GestionVoteBundle:admin:meilleurDislikeJurey.html.twig',array('articles'=>$articles));

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);


        return $this->render('GestionVoteBundle:admin:meilleurDislikeJurey.html.twig',array('articles'=>$articles));
    }


    /*meilleur like pour Cotch*/
    public function listeMeilleurdLikeCoatchAction()
    {

        $em=$this->getDoctrine()->getManager();
        $repository = $em->getRepository(Publication::class);
        $articles = $repository->findBy([], ['nbLikeCoatch' => 'desc']);
        return $this->render('GestionVoteBundle:admin:meilleurLikeCoatch.html.twig',array('articles'=>$articles));

    }
    /*imprime pdf meilleur like pour cotch*/
    public function PdflisteMeilleurdLikeCoatchAction()
    {

        $em=$this->getDoctrine()->getManager();
        $repository = $em->getRepository(Publication::class);
        $articles = $repository->findBy([], ['nbLikeCoatch' => 'desc']);
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $user=0;

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('GestionVoteBundle:admin:meilleurLikeCoatch.html.twig',array('articles'=>$articles));

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);

        return $this->render('GestionVoteBundle:admin:meilleurLikeCoatch.html.twig',array('articles'=>$articles));

    }
    /*meilleur dislike pour coatch*/
    public function listeMeilleurdisLikeCoatchAction()
    {
        $em=$this->getDoctrine()->getManager();
        $repository = $em->getRepository(Publication::class);
        $articles = $repository->findBy([], ['nbdislikeCoatch' => 'desc']);
        return $this->render('GestionVoteBundle:admin:meilleurDislikeCoatch.html.twig',array('articles'=>$articles));
    }
    /*imprime pdf dislike pour coath*/
    public function PdflisteMeilleurdisLikeCoatchAction()
    {
        $em=$this->getDoctrine()->getManager();
        $repository = $em->getRepository(Publication::class);
        $articles = $repository->findBy([], ['nbdislikeCoatch' => 'desc']);
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $user=0;

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('GestionVoteBundle:admin:meilleurDislikeCoatch.html.twig',array('articles'=>$articles));

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
        return $this->render('GestionVoteBundle:admin:meilleurDislikeCoatch.html.twig',array('articles'=>$articles));
    }

    /*meilleur like pour jurey*/
    public function listeMeilleurLike1Action()
    {
        $em=$this->getDoctrine()->getManager();
        $repository = $em->getRepository(Publication::class);
        $articles = $repository->findBy([], ['nbLikejurey' => 'desc']);

        return $this->render('GestionVoteBundle:admin:meilleurLikeJurey1.html.twig',array('articles'=>$articles));
    }
    /*imprime pdf meilleur like pour jurey*/
    public function PdflisteMeilleurLike1Action()
    {
        $em=$this->getDoctrine()->getManager();
        $repository = $em->getRepository(Publication::class);
        $articles = $repository->findBy([], ['nbLikejurey' => 'desc']);
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $user=0;

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('GestionVoteBundle:admin:meilleurLikeJurey1.html.twig',array('articles'=>$articles));

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);

        return $this->render('GestionVoteBundle:admin:meilleurLikeJurey1.html.twig',array('articles'=>$articles));
    }


    /* meilleur like pour coatch*/
    public function listeMeilleurdLikeCoatch1Action()
    {
        $em=$this->getDoctrine()->getManager();
        $repository = $em->getRepository(Publication::class);
        $articles = $repository->findBy([], ['nbLikeCoatch' => 'desc']);
        return $this->render('GestionVoteBundle:admin:meilleurLikeCoatch1.html.twig',array('articles'=>$articles));

    }
    /* imprime en pdf meilleur like pour coatch*/
    public function PdflisteMeilleurdLikeCoatch1Action()
    {
        $em=$this->getDoctrine()->getManager();
        $repository = $em->getRepository(Publication::class);
        $articles = $repository->findBy([], ['nbLikeCoatch' => 'desc']);
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $user=0;

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('GestionVoteBundle:admin:meilleurLikeCoatch1.html.twig',array('articles'=>$articles));

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
        return $this->render('GestionVoteBundle:admin:meilleurLikeCoatch1.html.twig',array('articles'=>$articles));

    }

/***************************************************************************************/
    public function like2Action(Publication $post)
    {

        $user=$this->getUser();
        $voteJurey= $this->getDoctrine()->getRepository(VoteCoatch::class)->findOneBy(['Publication' => $post, 'coatch' => $user]);
        if($user->getRole()==="cotch")
        {


            if ($post->isLikedByUserr($user)) {
                $voteJurey = $this->getDoctrine()->getRepository(VoteCoatch::class)->findOneBy(['Publication' => $post, 'coatch' => $user]);
                $manager = $this->getDoctrine()->getManager();
                $manager->remove($voteJurey);
                $manager->flush();
                /*donnée*/
                $voteJurey2 = $this->getDoctrine()->getRepository(VoteCoatch::class)->findBy(['Publication' => $post]);
                $dislike = $this->getDoctrine()->getRepository(VoteCotchNegative::class)->findBy(['Publication' => $post]);
                /* publication*/
                $em = $this->getDoctrine()->getManager();
                $user = $em->getRepository(Publication::class)->find($post->getId());
                $user->setNbLikeCoatch(count($voteJurey2));
                $user->setNbdislikeCoatch(count($dislike));
                $em->flush();
                /*publication*/

            }
            else
            {
                if($post->isLikedByUserDislike($user))
                {
                    $voteJurey = $this->getDoctrine()->getRepository(VoteCotchNegative::class)->findOneBy(['Publication' => $post, 'coatch' => $user]);
                    $manager = $this->getDoctrine()->getManager();
                    $manager->remove($voteJurey);
                    $manager->flush();
                    /*donnée*/
                    $voteJurey2 = $this->getDoctrine()->getRepository(VoteCoatch::class)->findBy(['Publication' => $post]);
                    $dislike = $this->getDoctrine()->getRepository(VoteCotchNegative::class)->findBy(['Publication' => $post]);
                    /* publication*/
                    $em = $this->getDoctrine()->getManager();
                    $user = $em->getRepository(Publication::class)->find($post->getId());
                    $user->setNbLikeCoatch(count($voteJurey2));
                    $user->setNbdislikeCoatch(count($dislike));
                    $em->flush();
                    /*publication*/
                }
                else
                {
                    $like = new VoteCoatch();
                    $like->setPublication($post);
                    $like->setCoatch($user);
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($like);
                    $manager->flush();
                    /*donnée*/
                    $voteJurey2 = $this->getDoctrine()->getRepository(VoteCoatch::class)->findBy(['Publication' => $post]);
                    $dislike = $this->getDoctrine()->getRepository(VoteCotchNegative::class)->findBy(['Publication' => $post]);
                    /* publication*/
                    $em = $this->getDoctrine()->getManager();
                    $user = $em->getRepository(Publication::class)->find($post->getId());
                    $user->setNbLikeCoatch(count($voteJurey2));
                    $user->setNbdislikeCoatch(count($dislike));
                    $em->flush();
                    /*publication*/

                }
            }
        }

        elseif ($user->getRole()==="jurey")
        {
            if ($post->isLikedJurey($user))
            {
                $voteJurey = $this->getDoctrine()->getRepository(VoteJureyLike::class)->findOneBy(['Publication' => $post, 'jurey' => $user]);
                $manager = $this->getDoctrine()->getManager();
                $manager->remove($voteJurey);
                $manager->flush();

            }
            else
            {
                if($post->isLikedJurey($user))
                {
                    $voteJurey = $this->getDoctrine()->getRepository(VoteJureyDilike::class)->findOneBy(['Publication' => $post, 'jurey' => $user]);
                    $manager = $this->getDoctrine()->getManager();
                    $manager->remove($voteJurey);
                    $manager->flush();
                }
                else
                {
                    $like = new VoteJureyLike();
                    $like->setPublication($post);
                    $like->setJurey($user);
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($like);
                    $manager->flush();

                }
            }
            $voteJurey2 = $this->getDoctrine()->getRepository(VoteJureyLike::class)->findBy(['Publication' => $post]);
            $dislike = $this->getDoctrine()->getRepository(VoteJureyDilike::class)->findBy(['Publication' => $post]);


        }

        return $this->json(
            [
                'code'=>858585,
                'message'=>'like bien suprimer',
                'likess'=>  '5'
            ], 200);

    }
/***************************************************************************************/
    public function dislikeAction(Publication $post)
    {

        $user=$this->getUser();
        $voteJurey= $this->getDoctrine()->getRepository(VoteCoatch::class)->findOneBy(['Publication' => $post, 'coatch' => $user]);
        $cotch=array("cotch");


        if($user->getRole()==="cotch")
        {
            if(($post->isLikedByUserDislike($user))&&($post->isLikedByUserDislike($user)))
            {
                $voteJurey = $this->getDoctrine()->getRepository(VoteCotchNegative::class)->findOneBy(['Publication' => $post, 'coatch' => $user]);
                $manager = $this->getDoctrine()->getManager();
                $manager->remove($voteJurey);
                $manager->flush();

                $voteJurey = $this->getDoctrine()->getRepository(VoteCotchNegative::class)->findOneBy(['Publication' => $post, 'coatch' => $user]);
                $manager = $this->getDoctrine()->getManager();
                $manager->remove($voteJurey);
                $manager->flush();
                /*donnée*/
                $voteJurey2 = $this->getDoctrine()->getRepository(VoteCoatch::class)->findBy(['Publication' => $post]);
                $dislike = $this->getDoctrine()->getRepository(VoteCotchNegative::class)->findBy(['Publication' => $post]);
                /* publication*/
                $em = $this->getDoctrine()->getManager();
                $user = $em->getRepository(Publication::class)->find($post->getId());
                $user->setNbLikeCoatch(count($voteJurey2));
                $user->setNbdislikeCoatch(count($dislike));
                $em->flush();
                /*publication*/
            }



            if($post->isLikedByUserDislike($user))
            {
                $voteJurey = $this->getDoctrine()->getRepository(VoteCotchNegative::class)->findOneBy(['Publication' => $post, 'coatch' => $user]);
                $manager = $this->getDoctrine()->getManager();
                $manager->remove($voteJurey);
                $manager->flush();
                /*donnée*/
                $voteJurey2 = $this->getDoctrine()->getRepository(VoteCoatch::class)->findBy(['Publication' => $post]);
                $dislike = $this->getDoctrine()->getRepository(VoteCotchNegative::class)->findBy(['Publication' => $post]);
                /* publication*/
                $em = $this->getDoctrine()->getManager();
                $user = $em->getRepository(Publication::class)->find($post->getId());
                $user->setNbLikeCoatch(count($voteJurey2));
                $user->setNbdislikeCoatch(count($dislike));
                $em->flush();
                /*publication*/
            }
            else
            {
                if ($post->isLikedByUserr($user))
                {
                    $voteJurey = $this->getDoctrine()->getRepository(VoteCoatch::class)->findOneBy(['Publication' => $post, 'coatch' => $user]);
                    $manager = $this->getDoctrine()->getManager();
                    $manager->remove($voteJurey);
                    $manager->flush();
                    /*donnée*/
                    $voteJurey2 = $this->getDoctrine()->getRepository(VoteCoatch::class)->findBy(['Publication' => $post]);
                    $dislike = $this->getDoctrine()->getRepository(VoteCotchNegative::class)->findBy(['Publication' => $post]);
                    /* publication*/
                    $em = $this->getDoctrine()->getManager();
                    $user = $em->getRepository(Publication::class)->find($post->getId());
                    $user->setNbLikeCoatch(count($voteJurey2));
                    $user->setNbdislikeCoatch(count($dislike));
                    $em->flush();


                }
                else
                {
                    $like = new VoteCotchNegative();
                    $like->setPublication($post);
                    $like->setCoatch($user);
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($like);
                    $manager->flush();
                    /*donnée*/
                    $voteJurey2 = $this->getDoctrine()->getRepository(VoteCoatch::class)->findBy(['Publication' => $post]);
                    $dislike = $this->getDoctrine()->getRepository(VoteCotchNegative::class)->findBy(['Publication' => $post]);
                    /* publication*/
                    $em = $this->getDoctrine()->getManager();
                    $user = $em->getRepository(Publication::class)->find($post->getId());
                    $user->setNbLikeCoatch(count($voteJurey2));
                    $user->setNbdislikeCoatch(count($dislike));
                    $em->flush();
                    /*publication*/

                }
            }
            /*donnée*/
            $voteJurey2 = $this->getDoctrine()->getRepository(VoteCoatch::class)->findBy(['Publication' => $post]);
            $dislike = $this->getDoctrine()->getRepository(VoteCotchNegative::class)->findBy(['Publication' => $post]);
            /* publication*/
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(Publication::class)->find($post->getId());
            $user->setNbLikeCoatch(count($voteJurey2));
            $user->setNbdislikeCoatch(count($dislike));
            $em->flush();
            /*publication*/
            return $this->json(
                [
                    'code' => 858585,
                    'message' => 'like bien suprimer',
                    'likess' => count($voteJurey2),
                    'dislike'=>count($dislike)
                ], 200);
        }
        elseif (($user->getRole()==="Jurey"))
        {

            if($post->isdisLikedJurey($user))
            {
                $voteJurey = $this->getDoctrine()->getRepository(VoteJureyDilike::class)->findOneBy(['Publication' => $post, 'jurey' => $user]);
                $manager = $this->getDoctrine()->getManager();
                $manager->remove($voteJurey);
                $manager->flush();
                /*donnée*/
                $voteJurey2 = $this->getDoctrine()->getRepository(VoteJureyLike::class)->findBy(['Publication' => $post]);
                $dislike = $this->getDoctrine()->getRepository(VoteJureyDilike::class)->findBy(['Publication' => $post]);
                /* publication*/
                $em = $this->getDoctrine()->getManager();
                $user = $em->getRepository(Publication::class)->find($post->getId());
                $user->setNbLikejurey(count($voteJurey2));
                $user->setNbdislikejurey(count($dislike));
                $em->flush();
                /*publication*/
            }
            else
            {
                if ($post->isLikedJurey($user))
                {
                    $voteJurey = $this->getDoctrine()->getRepository(VoteJureyLike::class)->findOneBy(['Publication' => $post, 'jurey' => $user]);
                    $manager = $this->getDoctrine()->getManager();
                    $manager->remove($voteJurey);
                    $manager->flush();
                    $voteJurey2 = $this->getDoctrine()->getRepository(VoteJureyLike::class)->findBy(['Publication' => $post]);
                    $dislike = $this->getDoctrine()->getRepository(VoteJureyDilike::class)->findBy(['Publication' => $post]);
                    /* publication*/
                    $em = $this->getDoctrine()->getManager();
                    $user = $em->getRepository(Publication::class)->find($post->getId());
                    $user->setNbLikejurey(count($voteJurey2));
                    $user->setNbdislikejurey(count($dislike));
                    $em->flush();


                }
                else
                {
                    $like = new VoteJureyDilike();
                    $like->setPublication($post);
                    $like->setJurey($user);
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($like);
                    $manager->flush();
                    /*donnée*/
                    $voteJurey2 = $this->getDoctrine()->getRepository(VoteJureyLike::class)->findBy(['Publication' => $post]);
                    $dislike = $this->getDoctrine()->getRepository(VoteJureyDilike::class)->findBy(['Publication' => $post]);
                    /* publication*/
                    $em = $this->getDoctrine()->getManager();
                    $user = $em->getRepository(Publication::class)->find($post->getId());
                    $user->setNbLikejurey(count($voteJurey2));
                    $user->setNbdislikejurey(count($dislike));
                    $em->flush();
                    /*publication*/

                }
            }
            /*donnée*/
            $voteJurey2 = $this->getDoctrine()->getRepository(VoteJureyLike::class)->findBy(['Publication' => $post]);
            $dislike = $this->getDoctrine()->getRepository(VoteJureyDilike::class)->findBy(['Publication' => $post]);
            /* publication*/
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(Publication::class)->find($post->getId());
            $user->setNbLikejurey(count($voteJurey2));
            $user->setNbdislikejurey(count($dislike));
            $em->flush();
            /*publication*/
            return $this->json(
                [
                    'code' => 858585,
                    'message' => 'like bien suprimer',
                    'likess' => count($voteJurey2),
                    'dislike'=>count($dislike)
                ], 200);
        }


        return $this->json(
            [
                'code' => 858585,
                'message' => 'like bien suprimer',
                'likess' => '55',
                'dislike'=>'count($dislike)'
            ], 200);
    }
/**************************************************************************************/

}
