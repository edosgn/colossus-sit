<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Clase
 *
 * @ORM\Table(name="clase")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClaseRepository")
 */
class Clase
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
     * @ORM\Column(name="nombreClase", type="string", length=255)
     */
    private $nombreClase;

    /**
     * @var int
     *
     * @ORM\Column(name="codigoClase", type="integer", unique=true)
     */
    private $codigoClase;


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
     * Set nombreClase
     *
     * @param string $nombreClase
     *
     * @return Clase
     */
    public function setNombreClase($nombreClase)
    {
        $this->nombreClase = $nombreClase;

        return $this;
    }

    /**
     * Get nombreClase
     *
     * @return string
     */
    public function getNombreClase()
    {
        return $this->nombreClase;
    }

    /**
     * Set codigoClase
     *
     * @param integer $codigoClase
     *
     * @return Clase
     */
    public function setCodigoClase($codigoClase)
    {
        $this->codigoClase = $codigoClase;

        return $this;
    }

    /**
     * Get codigoClase
     *
     * @return int
     */
    public function getCodigoClase()
    {
        return $this->codigoClase;
    }
}

