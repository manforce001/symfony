<?php

namespace GestionVoteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LikeCoach
 *
 * @ORM\Table(name="like_coach")
 * @ORM\Entity(repositoryClass="GestionVoteBundle\Repository\LikeCoachRepository")
 */
class LikeCoach
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * Get id
     *
     * @return int
     */



    /**
     * @ORM\ManyToOne(targetEntity="EvenementBundle\Entity\Participation", inversedBy="likescoach")
     */
    private $Publication;

    /**
     * @return mixed
     */
    public function getPublication()
    {
        return $this->Publication;
    }

    /**
     * @param mixed $Publication
     */
    public function setPublication($Publication)
    {
        $this->Publication = $Publication;
    }





    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="likescoach")
     */
    private $Jury;

    /**
     * @return mixed
     */
    public function getJury()
    {
        return $this->Jury;
    }

    /**
     * @param mixed $Jury
     */
    public function setJury($Jury)
    {
        $this->Jury = $Jury;
    }



    public function getId()
    {
        return $this->id;
    }
}

