<?php

namespace JHWEB\VehiculoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VhloTecnoMecanica
 *
 * @ORM\Table(name="vhlo_tecno_mecanica")
 * @ORM\Entity(repositoryClass="JHWEB\VehiculoBundle\Repository\VhloTecnoMecanicaRepository")
 */
class VhloTecnoMecanica
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
     * @ORM\Column(name="numero_control", type="string", length=255)
     */
    private $numeroControl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_expedicion", type="date")
     */
    private $fechaExpedicion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_vencimiento", type="date")
     */
    private $fechaVencimiento;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /** @ORM\ManyToOne(targetEntity="VhloCfgCda", inversedBy="tecnoMecanicas") */
    private $cda;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehiculo", inversedBy="tecnoMecanicas") */
    private $vehiculo;

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
     * Set numeroControl
     *
     * @param string $numeroControl
     *
     * @return VhloTecnoMecanica
     */
    public function setNumeroControl($numeroControl)
    {
        $this->numeroControl = $numeroControl;

        return $this;
    }

    /**
     * Get numeroControl
     *
     * @return string
     */
    public function getNumeroControl()
    {
        return $this->numeroControl;
    }

    /**
     * Set fechaExpedicion
     *
     * @param \DateTime $fechaExpedicion
     *
     * @return VhloTecnoMecanica
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
        return $this->fechaExpedicion;
    }

    /**
     * Set fechaVencimiento
     *
     * @param \DateTime $fechaVencimiento
     *
     * @return VhloTecnoMecanica
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
        return $this->fechaVencimiento;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return VhloTecnoMecanica
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
     * Set cda
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgCda $cda
     *
     * @return VhloTecnoMecanica
     */
    public function setCda(\JHWEB\VehiculoBundle\Entity\VhloCfgCda $cda = null)
    {
        $this->cda = $cda;

        return $this;
    }

    /**
     * Get cda
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgCda
     */
    public function getCda()
    {
        return $this->cda;
    }

    /**
     * Set vehiculo
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculo
     *
     * @return VhloTecnoMecanica
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
}
