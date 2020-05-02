<?php

namespace EvenementBundle\Entity;

use AncaRebeca\FullCalendarBundle\Model\FullCalendarEvent;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement")
 * @ORM\Entity(repositoryClass="EvenementBundle\Repository\EvenementRepository")
 */
class Evenement
{

    public function __construct()
    {
        $this->isPublic = true;
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
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    protected $title;

    /**
     * @var string
     * @Assert\NotBlank(message= "Le description doit etre obligatoire")
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var string
     * @Assert\NotBlank(message= "le localisation doit étre obligatoire")
     * @ORM\Column(name="localisation", type="string", length=255, nullable=false)
     */
    private $localisation;

    /**
     * @var string
     * @Assert\NotBlank(message= "l'etablissement doit etre obligatoire")
     * @ORM\Column(name="etablissement", type="string", length=255, nullable=false)
     */
    private $etablissement;
    /**
     * @var string
      * @ORM\Column(name="categories", type="string", length=255, nullable=false)
     */
    private $categories;

    /**
     * @var \DateTime
     * @Assert\Type("DateTime")
     * @ORM\Column(name="datedebut", type="date")
     */
    public $dateDebut;
    /**
     * @var \DateTime
     * @Assert\Type("DateTime")
     *  @ORM\Column(name="datefin", type="date")
     * @Assert\Expression("value >= this.dateDebut",message="la date de fin doit être postérieure à la date de début")
     */
    private $dateFin;



    /**
     * @var integer
     * @Assert\Range(
     *      min = 10,
     *      minMessage = "min 10 ",
     * )
     * @ORM\Column(name="nombreMinParticipants", type="integer", nullable=true)
     */
    private $nombreMinparticipants;


    /**
      *
     * @ORM\Column(name="isPublic", type="boolean", nullable=true)
     */
    private $isPublic;


    /**
     * @Assert\GreaterThan(
     *     value = -1,
     *    message="Attention!! votre prix ne doit pas etre negative"
     * )
     * @ORM\Column(name="prix", type="integer", nullable=true)
      */
    private $prix;

    /**
     *
     * @ORM\Column(name="is_public", type="boolean", nullable=true)
     */
    private $isPayed;

    /**
     * @var integer
     *
     * @ORM\Column(name="nombreMaxParticipants", type="integer", nullable=true)
     */
    private $nombreMaxparticipants;

    /**
     * @var string
     *
     * @ORM\Column(name="imagepath", type="string", length=255, nullable=false)
     */
    private $imagepath;
    /**
     * @var integer
     *
     * @ORM\Column(name="rating", type="integer", nullable=true)
     */
    private $rating;
    /**
     * @var integer
     *
     * @ORM\Column(name="nbactuel", type="integer", nullable=true)
     */
    private  $nbActuel;

    /**
     * @return int
     */
    public function getNbActuel()
    {
        return $this->nbActuel;
    }

    /**
     * @param int $nbActuel
     */
    public function setNbActuel($nbActuel)
    {
        $this->nbActuel = $nbActuel;
    }



    /**
     * @param int $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * @return integer
     */
    public function getRating()
    {
        return $this->rating;
    }



    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getLocalisation()
    {
        return $this->localisation;
    }

    /**
     * @param string $localisation
     */
    public function setLocalisation($localisation)
    {
        $this->localisation = $localisation;
    }

    /**
     * @return string
     */
    public function getEtablissement()
    {
        return $this->etablissement;
    }

    /**
     * @param string $etablissement
     */
    public function setEtablissement($etablissement)
    {
        $this->etablissement = $etablissement;
    }

    /**
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * @param \DateTime $dateDebut
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * @param \DateTime $dateFin
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;
    }




    /**
     * @return string
     */
    public function getImagepath()
    {
        return $this->imagepath;
    }

    /**
     * @param string $imagepath
     */
    public function setImagepath($imagepath)
    {
        $this->imagepath = $imagepath;
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
     * @return string
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param string $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * @return int
     */
    public function getNombreMinparticipants()
    {
        return $this->nombreMinparticipants;
    }

    /**
     * @param int $nombreMinparticipants
     */
    public function setNombreMinparticipants($nombreMinparticipants)
    {
        $this->nombreMinparticipants = $nombreMinparticipants;
    }

    /**
     * @return bool
     */
    public function isPublic()
    {
        return $this->isPublic;
    }

    /**
     * @param bool $isPublic
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;
    }

    /**
     * @return mixed
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param mixed $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return mixed
     */
    public function getIsPayed()
    {
        return $this->isPayed;
    }

    /**
     * @param mixed $isPayed
     */
    public function setIsPayed($isPayed)
    {
        $this->isPayed = $isPayed;
    }

    /**
     * @return int
     */
    public function getNombreMaxparticipants()
    {
        return $this->nombreMaxparticipants;
    }

    /**
     * @param int $nombreMaxparticipants
     */
    public function setNombreMaxparticipants($nombreMaxparticipants)
    {
        $this->nombreMaxparticipants = $nombreMaxparticipants;
    }




}

