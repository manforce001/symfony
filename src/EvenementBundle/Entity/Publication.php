<?php

namespace EvenementBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use UserBundle\Entity\User;

/**
 * Publication
 *
 * @ORM\Table(name="publication")
 * @ORM\Entity(repositoryClass="EvenementBundle\Repository\PublicationRepository")
 */
class Publication
{

    public function __construct()
    {
        $this->isValid = false;
        $this->isBlocked = false;
        $this->createdadd =new \DateTime();
        $this->likesJurey =new ArrayCollection ();
        $this->dislikeJury =new ArrayCollection();
        $this->likescoach =new ArrayCollection();
        $this->dislikesCoach =new ArrayCollection();



    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank(message= "Le titre doit étre obligatoire !")
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     * @Assert\NotBlank(message= "Le titre doit étre obligatoire !")
     * @ORM\Column(name="contenu", type="string", length=255)
     */
    private $contenu;


    /**
     * @var string
     * @Assert\NotBlank(message= "Le description doit étre obligatoire !")
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=255)
     */
    private $categorie;

    /**
     * @var string
     *
     * @ORM\Column(name="file", type="string", length=255,nullable=true)
     */
    private $file;

    /**
     *
     * @ORM\Column(name="createdadd", type="datetime", length=255,nullable=true)
     */
    private $createdadd;

    /**
     * @return mixed
     */
    public function getCreatedadd()
    {
        return $this->createdadd;
    }

    /**
     * @param mixed $createdadd
     */
    public function setCreatedadd($createdadd)
    {
        $this->createdadd = $createdadd;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="is_valid", type="boolean")
     */
    private $isValid;

    /**
     * @var string
     *
     * @ORM\Column(name="isBlocked", type="boolean")
     */
    private $isBlocked;
    /**
     * @ORM\ManyToOne(targetEntity="Evenement")
     * @ORM\JoinColumn(name="evenement_id", referencedColumnName="id")
     */
    private $evenement;
    /**
     * @var integer
     *
     * @ORM\Column(name="nbLikeCoatch", type="integer")
     */
    private $nbLikeCoatch;
    /**
     * @var integer
     *
     * @ORM\Column(name="nbLikeJurey", type="integer")
     */
    private $nbLikejurey;
    /**
     * @var integer
     *
     * @ORM\Column(name="nbdislikeJurey", type="integer")
     */
    private  $nbdislikeJurey;
    /**
     * @var integer
     *
     * @ORM\Column(name="nbdislikeCoatc", type="integer")
     */
    private $nbdislikeCoatch;

    /**
     * @return int
     */
    public function getNbLikeCoatch()
    {
        return $this->nbLikeCoatch;
    }

    /**
     * @param int $nbLikeCoatch
     */
    public function setNbLikeCoatch($nbLikeCoatch)
    {
        $this->nbLikeCoatch = $nbLikeCoatch;
    }

    /**
     * @return int
     */
    public function getNbLikejurey()
    {
        return $this->nbLikejurey;
    }

    /**
     * @param int $nbLikejurey
     */
    public function setNbLikejurey($nbLikejurey)
    {
        $this->nbLikejurey = $nbLikejurey;
    }

    /**
     * @return int
     */
    public function getNbdislikeJurey()
    {
        return $this->nbdislikeJurey;
    }

    /**
     * @param int $nbdislikeJurey
     */
    public function setNbdislikeJurey($nbdislikeJurey)
    {
        $this->nbdislikeJurey = $nbdislikeJurey;
    }

    /**
     * @return int
     */
    public function getNbdislikeCoatch()
    {
        return $this->nbdislikeCoatch;
    }

    /**
     * @param int $nbdislikeCoatch
     */
    public function setNbdislikeCoatch($nbdislikeCoatch)
    {
        $this->nbdislikeCoatch = $nbdislikeCoatch;
    }

    /**
     * @return ArrayCollection
     */
    public function getDislikesCoach()
    {
        return $this->dislikesCoach;
    }

    /**
     * @param ArrayCollection $dislikesCoach
     */
    public function setDislikesCoach($dislikesCoach)
    {
        $this->dislikesCoach = $dislikesCoach;
    }

    /**
     * @return ArrayCollection
     */
    public function getLikescoach()
    {
        return $this->likescoach;
    }

    /**
     * @param ArrayCollection $likescoach
     */
    public function setLikescoach($likescoach)
    {
        $this->likescoach = $likescoach;
    }

    /**
     * @return ArrayCollection
     */
    public function getDislikeJury()
    {
        return $this->dislikeJury;
    }

    /**
     * @param ArrayCollection $dislikeJury
     */
    public function setDislikeJury($dislikeJury)
    {
        $this->dislikeJury = $dislikeJury;
    }




    /**
     * @return mixed
     */
    public function getEvenement()
    {
        return $this->evenement;
    }

    /**
     * @param mixed $evenement
     */
    public function setEvenement($evenement)
    {
        $this->evenement = $evenement;
    }
    /**
     * @var \FOS\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="User_id", referencedColumnName="id")
     */

    private $User;
    /**
     *
     *
     * @ORM\OneToMany(targetEntity="GestionVoteBundle\Entity\LikeJurey",mappedBy="Publication")
     *
     */
    private $likesJurey;
    /**
     *
     *
     * @ORM\OneToMany(targetEntity="GestionVoteBundle\Entity\DislikeCoach",mappedBy="Publication")
     *
     */
    private $dislikesCoach;

    /**
     *
     *
     * @ORM\OneToMany(targetEntity="GestionVoteBundle\Entity\LikeCoach",mappedBy="Publication")
     *
     */
    private $likescoach;



    /**
     *
     *
     * @ORM\OneToMany(targetEntity="GestionVoteBundle\Entity\dislikeJury",mappedBy="Publication")
     *
     */
    private $dislikeJury;

    /**
     * @return mixed
     */
    public function getLikesJurey()
    {
        return $this->likesJurey;
    }

    /**
     * @param mixed $likesJurey
     */
    public function setLikesJurey($likesJurey)
    {
        $this->likesJurey = $likesJurey;
    }



    /**
     * @return \FOS\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->User;
    }

    /**
     * @param \FOS\UserBundle\Entity\User $User
     */
    public function setUser($User)
    {
        $this->User = $User;
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

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Publication
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Publication
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Publication
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set categorie
     *
     * @param string $categorie
     *
     * @return Publication
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @return string
     */
    public function getIsValid()
    {
        return $this->isValid;
    }

    /**
     * @param string $isValid
     */
    public function setIsValid($isValid)
    {
        $this->isValid = $isValid;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function getIsBlocked()
    {
        return $this->isBlocked;
    }

    /**
     * @param string $isBlocked
     */
    public function setIsBlocked($isBlocked)
    {
        $this->isBlocked = $isBlocked;
    }



    public function isLikedByUserr(User $user)
    {
        foreach ($this->likescoach as $likescoach)
        {
            if ($likescoach->getCoatch() === $user) {
                return true;
            }
        }

        return false;
    }

    public function isLikedByUserDislike(User $user)
    {
        foreach ($this->dislikesCoach as $dislikesCoach)
        {
            if ($dislikesCoach->getCoatch() === $user) {
                return true;
            }
        }

        return false;
    }
    /*liked bu jurey*/
    public function isLikedJurey(User $user)
    {
        foreach ($this->likesJurey as $likesJurey)
        {
            if ($likesJurey->getJurey() === $user) {
                return true;
            }
        }

        return false;
    }
    /*dislike pour jurey*/





    /**
     * @param User $user
     * @return bool
     */

    public function isdilikedJurey(User $user)
    {
        foreach ($this->dislikeJury as $dislikeJury)
        {
            if ($dislikeJury->getJurey() === $user) {
                return true;
            }
        }

        return false;
    }



}

