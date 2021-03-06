<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Activite_Agenda
 *
 * @ORM\Table(name="activite__agenda")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Activite_AgendaRepository")
 */
class Activite_Agenda
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
     * @ORM\ManyToOne(targetEntity="Activite")
     * @ORM\Column(name="idActivite", type="integer")
     */
    private $idActivite;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\Column(name="idUtilisateur", type="integer", nullable=true)
     */
    private $idUtilisateur;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="Agenda")
     * @ORM\Column(name="idAgenda", type="integer")
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
     * Set idAct
     *
     * @param integer $idAct
     *
     * @return Activite_Agenda
     */
    public function setIdAct($idAct)
    {
        $this->idAct = $idAct;

        return $this;
    }

    /**
     * Get idAct
     *
     * @return int
     */
    public function getIdAct()
    {
        return $this->idAct;
    }

    /**
     * Set idUtilisateur
     *
     * @param integer $idUtilisateur
     *
     * @return Activite_Agenda
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
     * Set idAg
     *
     * @param integer $idAg
     *
     * @return Activite_Agenda
     */
    public function setIdAg($idAg)
    {
        $this->idAg = $idAg;

        return $this;
    }

    /**
     * Get idAg
     *
     * @return int
     */
    public function getIdAg()
    {
        return $this->idAg;
    }

   

    /**
     * Set idAgenda
     *
     * @param integer $idAgenda
     *
     * @return Activite_Agenda
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
     * Set idActivite
     *
     * @param integer $idActivite
     *
     * @return Activite_Agenda
     */
    public function setIdActivite($idActivite)
    {
        $this->idActivite = $idActivite;

        return $this;
    }

    /**
     * Get idActivite
     *
     * @return integer
     */
    public function getIdActivite()
    {
        return $this->idActivite;
    }
}
