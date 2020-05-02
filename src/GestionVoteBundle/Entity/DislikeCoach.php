<?php

namespace GestionVoteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DislikeCoach
 *
 * @ORM\Table(name="dislike_coach")
 * @ORM\Entity(repositoryClass="GestionVoteBundle\Repository\DislikeCoachRepository")
 */
class DislikeCoach
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
     * @ORM\ManyToOne(targetEntity="EvenementBundle\Entity\Participation", inversedBy="dislikesCoach")
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
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="dislikesCoach")
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


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

