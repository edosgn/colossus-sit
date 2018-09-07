<?php

namespace JHWEB\VehiculoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Soat
 *
 * @ORM\Table(name="soat")
 * @ORM\Entity(repositoryClass="JHWEB\VehiculoBundle\Repository\SoatRepository")
 */
class Soat
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehiculo", inversedBy="tecnoMecanicas") */
    private $vehiculo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_expedicion", type="date")
     */
    private $fechaExpedicion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="vigencia", type="date")
     */
    private $vigencia;

    /**
     * @var int
     *
     * @ORM\Column(name="numero_poliza", type="date")
     */
    private $numeroPoliza;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_empresa", type="date")
     */
    private $nombreEmpresa;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Municipio", inversedBy="municipio") */
    private $municipio;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

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
     * Set fechaExpedicion
     *
     * @param \DateTime $fechaExpedicion
     *
     * @return Soat
     */
    public function setFechaExpedicion($fechaExpedicion)
    {
        $this->fechaExpedicion = $fechaExpedicion;

        return $this;
    }

    /**
     * Get fechaExpedicion
     *
     * @return \DateTime
     */
    public function getFechaExpedicion()
    {
        if ($this->fechaExpedicion) {
            return $this->fechaExpedicion->format('d/m/Y');
        }
        return $this->fechaExpedicion;

    }

    /**
     * Set vigencia
     *
     * @param \DateTime $vigencia
     *
     * @return Soat
     */
    public function setVigencia($vigencia)
    {
        $this->vigencia = $vigencia;
        return $this;
    }

    /**
     * Get vigencia
     *
     * @return \DateTime
     */
    public function getVigencia()
    {
        if ($this->vigencia) {
            return $this->vigencia->format('d/m/Y');
        }
        return $this->vigencia;
    }

    /**
     * Set numeroPoliza
     *
     * @param \DateTime $numeroPoliza
     *
     * @return Soat
     */
    public function setNumeroPoliza($numeroPoliza)
    {
        $this->numeroPoliza = $numeroPoliza;

        return $this;
    }

    /**
     * Get numeroPoliza
     *
     * @return \DateTime
     */
    public function getNumeroPoliza()
    {
        return $this->numeroPoliza;
    }

    /**
     * Set nombreEmpresa
     *
     * @param \DateTime $nombreEmpresa
     *
     * @return Soat
     */
    public function setNombreEmpresa($nombreEmpresa)
    {
        $this->nombreEmpresa = $nombreEmpresa;

        return $this;
    }

    /**
     * Get nombreEmpresa
     *
     * @return \DateTime
     */
    public function getNombreEmpresa()
    {
        return $this->nombreEmpresa;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Soat
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set vehiculo
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculo
     *
     * @return Soat
     */
    public function setVehiculo(\AppBundle\Entity\Vehiculo $vehiculo = null)
    {
        $this->vehiculo = $vehiculo;

        return $this;
    }

    /**
     * Get vehiculo
     *
     * @return \AppBundle\Entity\Vehiculo
     */
    public function getVehiculo()
    {
        return $this->vehiculo;
    }

    /**
     * Set municipio
     *
     * @param \AppBundle\Entity\Municipio $municipio
     *
     * @return Soat
     */
    public function setMunicipio(\AppBundle\Entity\Municipio $municipio = null)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return \AppBundle\Entity\Municipio
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }
}
