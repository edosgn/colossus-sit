<?php

namespace JHWEB\VehiculoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VhloSoat
 *
 * @ORM\Table(name="vhlo_soat")
 * @ORM\Entity(repositoryClass="JHWEB\VehiculoBundle\Repository\VhloSoatRepository")
 */
class VhloSoat
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_expedicion", type="date")
     */
    private $fechaExpedicion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_vigencia", type="date")
     */
    private $fechaVigencia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_vencimiento", type="date")
     */
    private $fechaVencimiento;

    /**
     * @var int
     *
     * @ORM\Column(name="numero_poliza", type="string")
     */
    private $numeroPoliza;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_empresa", type="string")
     */
    private $nombreEmpresa;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string")
     */
    private $estado;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehiculo", inversedBy="soats") */
    private $vehiculo;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Municipio", inversedBy="municipio") */
    private $municipio;


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
     * @return VhloSoat
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
     * Set fechaVigencia
     *
     * @param \DateTime $fechaVigencia
     *
     * @return VhloSoat
     */
    public function setFechaVigencia($fechaVigencia)
    {
        $this->fechaVigencia = $fechaVigencia;

        return $this;
    }

    /**
     * Get fechaVigencia
     *
     * @return \DateTime
     */
    public function getFechaVigencia()
    {
        if ($this->fechaVigencia) {
            return $this->fechaVigencia->format('d/m/Y');
        }
        return $this->fechaVigencia;
    }

    /**
     * Set fechaVencimiento
     *
     * @param \DateTime $fechaVencimiento
     *
     * @return VhloSoat
     */
    public function setFechaVencimiento($fechaVencimiento)
    {
        $this->fechaVencimiento = $fechaVencimiento;

        return $this;
    }

    /**
     * Get fechaVencimiento
     *
     * @return \DateTime
     */
    public function getFechaVencimiento()
    {
        if ($this->fechaVencimiento) {
            return $this->fechaVencimiento->format('d/m/Y');
        }
        return $this->fechaVencimiento;
    }

    /**
     * Set numeroPoliza
     *
     * @param string $numeroPoliza
     *
     * @return VhloSoat
     */
    public function setNumeroPoliza($numeroPoliza)
    {
        $this->numeroPoliza = $numeroPoliza;

        return $this;
    }

    /**
     * Get numeroPoliza
     *
     * @return string
     */
    public function getNumeroPoliza()
    {
        return $this->numeroPoliza;
    }

    /**
     * Set nombreEmpresa
     *
     * @param string $nombreEmpresa
     *
     * @return VhloSoat
     */
    public function setNombreEmpresa($nombreEmpresa)
    {
        $this->nombreEmpresa = $nombreEmpresa;

        return $this;
    }

    /**
     * Get nombreEmpresa
     *
     * @return string
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
     * @return VhloSoat
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
     * Set estado
     *
     * @param string $estado
     *
     * @return VhloSoat
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set vehiculo
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculo
     *
     * @return VhloSoat
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
     * @return VhloSoat
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
