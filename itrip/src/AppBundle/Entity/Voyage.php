<?php

namespace AppBundle\Entity;
use AppBundle\Entity\MoneyPot;
use AppBundle\Entity\Agenda;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

use Doctrine\ORM\Mapping as ORM;

/**
 * Voyage
 *
 * @ORM\Table(name="voyage")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VoyageRepository")
 */
class Voyage
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
     *
     *@ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     *@ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;


    /**
     * @var int
     * @ORM\OneToOne(targetEntity="MoneyPot")
     * @ORM\Column(name="idMoneyPot", type="integer", nullable=true)
     */
    private $idMoneyPot;

    /**
     * @var int
     * @ORM\OneToOne(targetEntity="Location")
     * @ORM\Column(name="idLocation", type="integer", nullable=true)
     */
    private $idLocation;

    /**
     * @var bool
     *
     * @ORM\Column(name="isActif", type="boolean",nullable=true)
     */
    private $isActif;

    /**
     * @var int
     * @ORM\OneToOne(targetEntity="Agenda")
     * @ORM\Column(name="idAgenda", type="integer", nullable=true)
     */
    private $idAgenda;

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
     * Set idMoneyPot
     *
     * @param integer $idMoneyPot
     *
     * @return Voyage
     */
    public function setIdMoneyPot($idMoneyPot)
    {
        $this->idMoneyPot = $idMoneyPot;

        return $this;
    }

    /**
     * Get idMoneyPot
     *
     * @return int
     */
    public function getIdMoneyPot()
    {
        return $this->idMoneyPot;
    }

    /**
     * Set idLocation
     *
     * @param integer $idLocation
     *
     * @return Voyage
     */
    public function setIdLocation($idLocation)
    {
        $this->idLocation = $idLocation;

        return $this;
    }

    /**
     * Get idLocation
     *
     * @return int
     */
    public function getIdLocation()
    {
        return $this->idLocation;
    }

    /**
     * Set isActif
     *
     * @param boolean $isActif
     *
     * @return Voyage
     */
    public function setIsActif($isActif)
    {
        $this->isActif = $isActif;

        return $this;
    }

    /**
     * Get isActif
     *
     * @return bool
     */
    public function getIsActif()
    {
        return $this->isActif;
    }

    /**
     * Set idAgenda
     *
     * @param integer $idAgenda
     *
     * @return Voyage
     */
    public function setIdAgenda($idAgenda)
    {
        $this->idAgenda = $idAgenda;

        return $this;
    }

    /**
     * Get idAgenda
     *
     * @return integer
     */
    public function getIdAgenda()
    {
        return $this->idAgenda;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Voyage
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


    public function __construct()
    {
        //$fs = new Filesystem();
        //$fs->mkdir('/img/voyage/'.$this->getId());
        
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Voyage
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
}
