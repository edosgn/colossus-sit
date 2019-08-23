<?php

namespace JHWEB\VehiculoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VhloTpConvenio
 *
 * @ORM\Table(name="vhlo_tp_convenio")
 * @ORM\Entity(repositoryClass="JHWEB\VehiculoBundle\Repository\VhloTpConvenioRepository")
 */
class VhloTpConvenio
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
     * @ORM\Column(name="numero_convenio", type="integer")
     */
    private $numeroConvenio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_convenio", type="date", nullable=true)
     */
    private $fechaConvenio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_acta_inicio", type="date", nullable=true)
     */
    private $fechaActaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_acta_fin", type="date", nullable=true)
     */
    private $fechaActaFin;

    /**
     * @var int
     *
     * @ORM\Column(name="numero_cupos", type="integer")
     */
    private $numeroCupos;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="string", length=255, nullable=true)
     */
    private $observacion;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    
    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserEmpresa")
     */
    private $alcaldia;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set numeroConvenio
     *
     * @param integer $numeroConvenio
     *
     * @return VhloTpConvenio
     */
    public function setNumeroConvenio($numeroConvenio)
    {
        $this->numeroConvenio = $numeroConvenio;

        return $this;
    }

    /**
     * Get numeroConvenio
     *
     * @return integer
     */
    public function getNumeroConvenio()
    {
        return $this->numeroConvenio;
    }

    /**
     * Set fechaConvenio
     *
     * @param \DateTime $fechaConvenio
     *
     * @return VhloTpConvenio
     */
    public function setFechaConvenio($fechaConvenio)
    {
        $this->fechaConvenio = $fechaConvenio;

        return $this;
    }

    /**
     * Get fechaConvenio
     *
     * @return \DateTime
     */
    public function getFechaConvenio()
    {
        return $this->fechaConvenio;
    }

    /**
     * Set fechaActaInicio
     *
     * @param \DateTime $fechaActaInicio
     *
     * @return VhloTpConvenio
     */
    public function setFechaActaInicio($fechaActaInicio)
    {
        $this->fechaActaInicio = $fechaActaInicio;

        return $this;
    }

    /**
     * Get fechaActaInicio
     *
     * @return \DateTime
     */
    public function getFechaActaInicio()
    {
        return $this->fechaActaInicio;
    }

    /**
     * Set fechaActaFin
     *
     * @param \DateTime $fechaActaFin
     *
     * @return VhloTpConvenio
     */
    public function setFechaActaFin($fechaActaFin)
    {
        $this->fechaActaFin = $fechaActaFin;

        return $this;
    }

    /**
     * Get fechaActaFin
     *
     * @return \DateTime
     */
    public function getFechaActaFin()
    {
        return $this->fechaActaFin;
    }

    /**
     * Set numeroCupos
     *
     * @param integer $numeroCupos
     *
     * @return VhloTpConvenio
     */
    public function setNumeroCupos($numeroCupos)
    {
        $this->numeroCupos = $numeroCupos;

        return $this;
    }

    /**
     * Get numeroCupos
     *
     * @return integer
     */
    public function getNumeroCupos()
    {
        return $this->numeroCupos;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     *
     * @return VhloTpConvenio
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return VhloTpConvenio
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
     * Set alcaldia
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserEmpresa $alcaldia
     *
     * @return VhloTpConvenio
     */
    public function setAlcaldia(\JHWEB\UsuarioBundle\Entity\UserEmpresa $alcaldia = null)
    {
        $this->alcaldia = $alcaldia;

        return $this;
    }

    /**
     * Get alcaldia
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserEmpresa
     */
    public function getAlcaldia()
    {
        return $this->alcaldia;
    }
}
