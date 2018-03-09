<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transaction
 *
 * @ORM\Table(name="transaction")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TransactionRepository")
 */
class Transaction
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
     * @ORM\ManyToOne(targetEntity="MoneyPot")
     * @ORM\Column(name="idMoneyPot", type="integer")
     */
    private $idMoneyPot;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\Column(name="idUtilisateur", type="integer")
     */
    private $idUtilisateur;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_transaction", type="datetime")
     */
    private $dateTransaction;

    /**
     * @var int
     *
     * @ORM\Column(name="valeur", type="integer")
     */
    private $valeur;


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
     * @return Transaction
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
     * Set dateTransaction
     *
     * @param \DateTime $dateTransaction
     *
     * @return Transaction
     */
    public function setDateTransaction($dateTransaction)
    {
        $this->dateTransaction = $dateTransaction;

        return $this;
    }

    /**
     * Get dateTransaction
     *
     * @return \DateTime
     */
    public function getDateTransaction()
    {
        return $this->dateTransaction;
    }

    /**
     * Set valeur
     *
     * @param integer $valeur
     *
     * @return Transaction
     */
    public function setValeur($valeur)
    {
        $this->valeur = $valeur;

        return $this;
    }

    /**
     * Get valeur
     *
     * @return int
     */
    public function getValeur()
    {
        return $this->valeur;
    }

    /**
     * Set idMoneyPot
     *
     * @param integer $idMoneyPot
     *
     * @return Transaction
     */
    public function setIdMoneyPot($idMoneyPot)
    {
        $this->idMoneyPot = $idMoneyPot;

        return $this;
    }

    /**
     * Get idMoneyPot
     *
     * @return integer
     */
    public function getIdMoneyPot()
    {
        return $this->idMoneyPot;
    }
}
