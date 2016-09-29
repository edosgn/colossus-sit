<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Servicio
 *
 * @ORM\Table(name="servicio")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ServicioRepository")
 */
class Servicio
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
     * @ORM\Column(name="nombreServicio", type="string", length=255)
     */
    private $nombreServicio;

    /**
     * @var int
     *
     * @ORM\Column(name="codigoServicio", type="integer", unique=true)
     */
    private $codigoServicio;


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
     * Set nombreServicio
     *
     * @param string $nombreServicio
     *
     * @return Servicio
     */
    public function setNombreServicio($nombreServicio)
    {
        $this->nombreServicio = $nombreServicio;

        return $this;
    }

    /**
     * Get nombreServicio
     *
     * @return string
     */
    public function getNombreServicio()
    {
        return $this->nombreServicio;
    }

    /**
     * Set codigoServicio
     *
     * @param integer $codigoServicio
     *
     * @return Servicio
     */
    public function setCodigoServicio($codigoServicio)
    {
        $this->codigoServicio = $codigoServicio;

        return $this;
    }

    /**
     * Get codigoServicio
     *
     * @return int
     */
    public function getCodigoServicio()
    {
        return $this->codigoServicio;
    }
}

