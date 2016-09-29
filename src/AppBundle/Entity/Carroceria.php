<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Carroceria
 *
 * @ORM\Table(name="carroceria")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CarroceriaRepository")
 */
class Carroceria
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
     * @ORM\Column(name="nombreCarroceria", type="string", length=255)
     */
    private $nombreCarroceria;

    /**
     * @var int
     *
     * @ORM\Column(name="codigoCarroceria", type="integer", unique=true)
     */
    private $codigoCarroceria;


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
     * Set nombreCarroceria
     *
     * @param string $nombreCarroceria
     *
     * @return Carroceria
     */
    public function setNombreCarroceria($nombreCarroceria)
    {
        $this->nombreCarroceria = $nombreCarroceria;

        return $this;
    }

    /**
     * Get nombreCarroceria
     *
     * @return string
     */
    public function getNombreCarroceria()
    {
        return $this->nombreCarroceria;
    }

    /**
     * Set codigoCarroceria
     *
     * @param integer $codigoCarroceria
     *
     * @return Carroceria
     */
    public function setCodigoCarroceria($codigoCarroceria)
    {
        $this->codigoCarroceria = $codigoCarroceria;

        return $this;
    }

    /**
     * Get codigoCarroceria
     *
     * @return int
     */
    public function getCodigoCarroceria()
    {
        return $this->codigoCarroceria;
    }
}

