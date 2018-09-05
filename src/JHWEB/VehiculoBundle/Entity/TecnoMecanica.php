<?php

namespace JHWEB\VehiculoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TecnoMecanica
 *
 * @ORM\Table(name="tecno_mecanica")
 * @ORM\Entity(repositoryClass="JHWEB\VehiculoBundle\Repository\TecnoMecanicaRepository")
 */
class TecnoMecanica
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

    /** @ORM\ManyToOne(targetEntity="CfgCda", inversedBy="tecnoMecanicas") */
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
     * @return TecnoMecanica
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
     * @return TecnoMecanica
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
     * Set fechaVencimiento
     *
     * @param \DateTime $fechaVencimiento
     *
     * @return TecnoMecanica
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return TecnoMecanica
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return bool
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set cda
     *
     * @param \JHWEB\VehiculoBundle\Entity\CfgCda $cda
     *
     * @return TecnoMecanica
     */
    public function setCda(\JHWEB\VehiculoBundle\Entity\CfgCda $cda = null)
    {
        $this->cda = $cda;

        return $this;
    }

    /**
     * Get cda
     *
     * @return \JHWEB\VehiculoBundle\Entity\CfgCda
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
     * @return TecnoMecanica
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
