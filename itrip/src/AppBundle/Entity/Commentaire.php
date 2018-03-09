<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentaireRepository")
 */
class Commentaire
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
     * @ORM\ManyToOne(targetEntity="Voyage")
     * @ORM\Column(name="idVoyage", type="integer")
     */
    private $idVoyage;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_commentaire", type="datetime")
     */
    private $dateCommentaire;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     */
    private $message;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\Column(name="idUtilisateur", type="integer")
     */
    private $idUtilisateur;


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
     * Set dateCommentaire
     *
     * @param \DateTime $dateCommentaire
     *
     * @return Commentaire
     */
    public function setDateCommentaire($dateCommentaire)
    {
        $this->dateCommentaire = $dateCommentaire;

        return $this;
    }

    /**
     * Get dateCommentaire
     *
     * @return \DateTime
     */
    public function getDateCommentaire()
    {
        return $this->dateCommentaire;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Commentaire
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set idUtilisateur
     *
     * @param integer $idUtilisateur
     *
     * @return Commentaire
     */
    public function setidUtilisateur($idUtilisateur)
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }

    /**
     * Get idUtilisateur
     *
     * @return int
     */
    public function getidUtilisateur()
    {
        return $this->idUtilisateur;
    }

    /**
     * Set idVoyage
     *
     * @param integer $idVoyage
     *
     * @return Commentaire
     */
    public function setIdVoyage($idVoyage)
    {
        $this->idVoyage = $idVoyage;

        return $this;
    }

    /**
     * Get idVoyage
     *
     * @return integer
     */
    public function getIdVoyage()
    {
        return $this->idVoyage;
    }
}
