<?php

namespace JHWEB\VehiculoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VhloTpRango
 *
 * @ORM\Table(name="vhlo_tp_rango")
 * @ORM\Entity(repositoryClass="JHWEB\VehiculoBundle\Repository\VhloTpRangoRepository")
 */
class VhloTpRango
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

     /** @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserEmpresaTransporte", inversedBy="rangos") */
    private $habilitacion;

    /**
     * @var int
     *
     * @ORM\Column(name="rango_inicio", type="bigint", nullable=true)
     */
    private $rangoInicio;
    
    /**
     * @var int
     *
     * @ORM\Column(name="rango_fin", type="bigint", nullable=true)
     */
    private $rangoFin;
    
    /**
     * @var int
     *
     * @ORM\Column(name="numero_resolucion_cupo", type="bigint", nullable=true)
     */
    private $numeroResolucionCupo;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_resolucion_cupo", type="date", nullable=true)
     */
    private $fechaResolucionCupo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", nullable=true)
     */
    private $observaciones;

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
     * Set rangoInicio
     *
     * @param integer $rangoInicio
     *
     * @return VhloTpRango
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
     * @return VhloTpRango
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
     * Set numeroResolucionCupo
     *
     * @param integer $numeroResolucionCupo
     *
     * @return VhloTpRango
     */
    public function setNumeroResolucionCupo($numeroResolucionCupo)
    {
        $this->numeroResolucionCupo = $numeroResolucionCupo;

        return $this;
    }

    /**
     * Get numeroResolucionCupo
     *
     * @return integer
     */
    public function getNumeroResolucionCupo()
    {
        return $this->numeroResolucionCupo;
    }

    /**
     * Set fechaResolucionCupo
     *
     * @param \DateTime $fechaResolucionCupo
     *
     * @return VhloTpRango
     */
    public function setFechaResolucionCupo($fechaResolucionCupo)
    {
        $this->fechaResolucionCupo = $fechaResolucionCupo;

        return $this;
    }

    /**
     * Get fechaResolucionCupo
     *
     * @return \DateTime
     */
    public function getFechaResolucionCupo()
    {
        return $this->fechaResolucionCupo;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return VhloTpRango
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return VhloTpRango
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
     * Set habilitacion
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserEmpresaTransporte $habilitacion
     *
     * @return VhloTpRango
     */
    public function setHabilitacion(\JHWEB\UsuarioBundle\Entity\UserEmpresaTransporte $habilitacion = null)
    {
        $this->habilitacion = $habilitacion;

        return $this;
    }

    /**
     * Get habilitacion
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserEmpresaTransporte
     */
    public function getHabilitacion()
    {
        return $this->habilitacion;
    }
}
