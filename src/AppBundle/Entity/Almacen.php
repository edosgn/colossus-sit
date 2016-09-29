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
     * @var int
     *
     * @ORM\Column(name="idLote", type="integer")
     */
    private $idLote;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Servicio", inversedBy="almacenes") */
    private $servicio; 

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organismo", inversedBy="almacenes") */
    private $organismo; 

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Consumible", inversedBy="almacenes") */
    private $consumible;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Clase", inversedBy="almacenes") */
    private $clase; 


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

    /**
     * Set idLote
     *
     * @param integer $idLote
     *
     * @return Almacen
     */
    public function setIdLote($idLote)
    {
        $this->idLote = $idLote;

        return $this;
    }

    /**
     * Get idLote
     *
     * @return integer
     */
    public function getIdLote()
    {
        return $this->idLote;
    }

    /**
     * Set servicio
     *
     * @param \AppBundle\Entity\Servicio $servicio
     *
     * @return Almacen
     */
    public function setServicio(\AppBundle\Entity\Servicio $servicio = null)
    {
        $this->servicio = $servicio;

        return $this;
    }

    /**
     * Get servicio
     *
     * @return \AppBundle\Entity\Servicio
     */
    public function getServicio()
    {
        return $this->servicio;
    }

    /**
     * Set organismo
     *
     * @param \AppBundle\Entity\Organismo $organismo
     *
     * @return Almacen
     */
    public function setOrganismo(\AppBundle\Entity\Organismo $organismo = null)
    {
        $this->organismo = $organismo;

        return $this;
    }

    /**
     * Get organismo
     *
     * @return \AppBundle\Entity\Organismo
     */
    public function getOrganismo()
    {
        return $this->organismo;
    }

    /**
     * Set consumible
     *
     * @param \AppBundle\Entity\Consumible $consumible
     *
     * @return Almacen
     */
    public function setConsumible(\AppBundle\Entity\Consumible $consumible = null)
    {
        $this->consumible = $consumible;

        return $this;
    }

    /**
     * Get consumible
     *
     * @return \AppBundle\Entity\Consumible
     */
    public function getConsumible()
    {
        return $this->consumible;
    }

    /**
     * Set clase
     *
     * @param \AppBundle\Entity\Clase $clase
     *
     * @return Almacen
     */
    public function setClase(\AppBundle\Entity\Clase $clase = null)
    {
        $this->clase = $clase;

        return $this;
    }

    /**
     * Get clase
     *
     * @return \AppBundle\Entity\Clase
     */
    public function getClase()
    {
        return $this->clase;
    }
}
