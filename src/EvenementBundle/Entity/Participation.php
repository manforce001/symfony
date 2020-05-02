<?php

namespace EvenementBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participation
 *
 * @ORM\Table(name="participati")
 * @ORM\Entity(repositoryClass="EvenementBundle\Repository\ParticipationRepository")
 */
class Participation
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
     * @var string
     *@Assert\NotBlank(message= "Le nom doit étre obligatoire !")
     * @ORM\Column(name="nom", type="string", length=20)
     */
    private $nom;

    /**
     * @var string
     *@Assert\NotBlank(message= "Le prenom doit étre obligatoire !")
     * @ORM\Column(name="prenom", type="string", length=20)
     */
    private $prenom;

    /**
     * @var string
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.")
     * @ORM\Column(name="Email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid $cin ."
     * )
     * @ORM\Column(name="Cin", type="string", length=255)
     */
    private $cin;

    /**
     * @var integer
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid $cin ."
     * )
     * @ORM\Column(name="numtel", type="integer", length=255)
     */
    private $numtel;
    /**
     * @ORM\ManyToOne(targetEntity="Evenement")
     * @ORM\JoinColumn(name="evenement_id", referencedColumnName="id")
     */
    private $evenement;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Participation
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Participation
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Participation
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set cin
     *
     * @param string $cin
     *
     * @return Participation
     */
    public function setCin($cin)
    {
        $this->cin = $cin;

        return $this;
    }

    /**
     * Get cin
     *
     * @return integer
     *
     */
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * Set numtel
     *
     * @param integer $numtel
     *
     * @return Participation
     */
    public function setNumtel($numtel)
    {
        $this->numtel = $numtel;

        return $this;
    }

    /**
     * Get numtel
     *
     * @return integer
     */
    public function getNumtel()
    {
        return $this->numtel;
    }
}

