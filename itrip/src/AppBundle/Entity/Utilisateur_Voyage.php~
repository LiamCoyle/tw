<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Utilisateur_Voyage
 *
 * @ORM\Table(name="utilisateur__voyage")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Utilisateur_VoyageRepository")
 * @UniqueEntity(fields= {"idUtilisateur", "idVoyage"})
 */
class Utilisateur_Voyage
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
     * @var int
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\Column(name="idUtilisateur", type="integer")
     */
    private $idUtilisateur;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="Voyage")
     * @ORM\Column(name="idVoyage", type="integer")
     */
    private $idVoyage;

    /**
     * @var boolean
     * 
     * @ORM\Column(name="isCreator", type="boolean")
     */
    private $isCreator;


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
     * Set idUtilisateur
     *
     * @param integer $idUtilisateur
     *
     * @return Utilisateur_Voyage
     */
    public function setIdUtilisateur($idUtilisateur)
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }

    /**
     * Get idUtilisateur
     *
     * @return int
     */
    public function getIdUtilisateur()
    {
        return $this->idUtilisateur;
    }

    /**
     * Set idVoyage
     *
     * @param integer $idVoyage
     *
     * @return Utilisateur_Voyage
     */
    public function setIdVoyage($idVoyage)
    {
        $this->idVoyage = $idVoyage;

        return $this;
    }

    /**
     * Get idVoyage
     *
     * @return int
     */
    public function getIdVoyage()
    {
        return $this->idVoyage;
    }

    /**
     * Set isCreator
     *
     * @param boolean $isCreator
     *
     * @return Utilisateur_Voyage
     */
    public function setIsCreator($isCreator)
    {
        $this->isCreator = $isCreator;

        return $this;
    }

    /**
     * Get isCreator
     *
     * @return boolean
     */
    public function getIsCreator()
    {
        return $this->isCreator;
    }
}
