<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Almacen
 *
 * @ORM\Table(name="almacen")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AlmacenRepository")
 */
class Almacen
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
     *
     * @ORM\Column(name="rangoInicio", type="integer")
     */
    private $rangoInicio;

    /**
     * @var int
     *
     * @ORM\Column(name="rangoFin", type="integer")
     */
    private $rangoFin;


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
     * Set rangoInicio
     *
     * @param integer $rangoInicio
     *
     * @return Almacen
     */
    public function setRangoInicio($rangoInicio)
    {
        $this->rangoInicio = $rangoInicio;

        return $this;
    }

    /**
     * Get rangoInicio
     *
     * @return int
     */
    public function getRangoInicio()
    {
        return $this->rangoInicio;
    }

    /**
     * Set rangoFin
     *
     * @param integer $rangoFin
     *
     * @return Almacen
     */
    public function setRangoFin($rangoFin)
    {
        $this->rangoFin = $rangoFin;

        return $this;
    }

    /**
     * Get rangoFin
     *
     * @return int
     */
    public function getRangoFin()
    {
        return $this->rangoFin;
    }
}

