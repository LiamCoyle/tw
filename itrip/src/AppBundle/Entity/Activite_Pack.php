<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Activite_Pack
 *
 * @ORM\Table(name="activite__pack")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Activite_PackRepository")
 */
class Activite_Pack
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
     * @ORM\ManyToOne(targetEntity="Pack")
     * @ORM\Column(name="idPack", type="integer")
     */
    private $idPack;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="Activte")
     * @ORM\Column(name="idActivite", type="integer")
     */
    private $idActivite;


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
     * Set idPack
     *
     * @param integer $idPack
     *
     * @return Activite_Pack
     */
    public function setIdPack($idPack)
    {
        $this->idPack = $idPack;

        return $this;
    }

    /**
     * Get idPack
     *
     * @return int
     */
    public function getIdPack()
    {
        return $this->idPack;
    }

    /**
     * Set idActivite
     *
     * @param integer $idActivite
     *
     * @return Activite_Pack
     */
    public function setIdActivite($idActivite)
    {
        $this->idActivite = $idActivite;

        return $this;
    }

    /**
     * Get idActivite
     *
     * @return int
     */
    public function getIdActivite()
    {
        return $this->idActivite;
    }
}

