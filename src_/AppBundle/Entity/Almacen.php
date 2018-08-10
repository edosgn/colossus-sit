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
     * @ORM\Column(name="rango_inicio", type="integer")
     */
    private $rangoInicio;

    /**
     * @var int
     *
     * @ORM\Column(name="rango_fin", type="integer")
     */
    private $rangoFin;

    /**
     * @var int
     *
     * @ORM\Column(name="lote", type="integer")
     */
    private $lote;

     /**
     * @var array
     *
     * @ORM\Column(name="disponibles", type="array")
     */
    private $disponibles;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Servicio", inversedBy="almacenes") */
    private $servicio; 

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\OrganismoTransito", inversedBy="almacenes") */
    private $organismoTransito; 

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
     * @return integer
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
     * @return integer
     */
    public function getRangoFin()
    {
        return $this->rangoFin;
    }

    /**
     * Set lote
     *
     * @param integer $lote
     *
     * @return Almacen
     */
    public function setLote($lote)
    {
        $this->lote = $lote;

        return $this;
    }

    /**
     * Get lote
     *
     * @return integer
     */
    public function getLote()
    {
        return $this->lote;
    }

    /**
     * Set disponibles
     *
     * @param array $disponibles
     *
     * @return Almacen
     */
    public function setDisponibles($disponibles = null)
    {
        $this->disponibles = $disponibles;

        return $this;
    }

    /**
     * Get disponibles
     *
     * @return array
     */
    public function getDisponibles()
    {
        return $this->disponibles;
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
     * Set organismoTransito
     *
     * @param \AppBundle\Entity\OrganismoTransito $organismoTransito
     *
     * @return Almacen
     */
    public function setOrganismoTransito(\AppBundle\Entity\OrganismoTransito $organismoTransito = null)
    {
        $this->organismoTransito = $organismoTransito;

        return $this;
    }

    /**
     * Get organismoTransito
     *
     * @return \AppBundle\Entity\OrganismoTransito
     */
    public function getOrganismoTransito()
    {
        return $this->organismoTransito;
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

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return Almacen
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean
     */
    public function getEstado()
    {
        return $this->estado;
    }
}
