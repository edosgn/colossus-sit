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
     * @ORM\Column(name="numeroConvenio", type="integer")
     */
    private $numeroConvenio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaConvenio", type="date")
     */
    private $fechaConvenio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaActaInicio", type="date")
     */
    private $fechaActaInicio;

    /**
     * @var string
     *
     * @ORM\Column(name="fechaActaFin", type="date", length=255)
     */
    private $fechaActaFin;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="string", length=255)
     */
    private $observacion;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\OneToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserEmpresa")
     */
    private $empresa;

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
        if ($this->fechaConvenio) {
            return $this->fechaConvenio->format('d/m/Y');
        }
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
        if ($this->fechaActaInicio) {
            return $this->fechaActaInicio->format('d/m/Y');
        }
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
        if ($this->fechaActaFin) {
            return $this->fechaActaFin->format('d/m/Y');
        }
        return $this->fechaActaFin;
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
     * Set empresa
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserEmpresa $empresa
     *
     * @return VhloTpConvenio
     */
    public function setEmpresa(\JHWEB\UsuarioBundle\Entity\UserEmpresa $empresa = null)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserEmpresa
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }
}
