<?php

namespace JHWEB\UsuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserMedidaCautelar
 *
 * @ORM\Table(name="user_medida_cautelar")
 * @ORM\Entity(repositoryClass="JHWEB\UsuarioBundle\Repository\UserMedidaCautelarRepository")
 */
class UserMedidaCautelar
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
     * @ORM\Column(name="numero_oficio", type="string", length=100)
     */
    private $numeroOficio;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_radicado", type="string", length=100)
     */
    private $numeroRadicado;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="text")
     */
    private $observaciones;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_registro", type="date")
     */
    private $fechaRegistro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_inicio", type="date")
     */
    private $fechaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_expiracion", type="date")
     */
    private $fechaExpiracion;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_levantamiento", type="date", nullable=true)
     */
    private $fechaLevantamiento;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_oficio_levantamiento", type="string", length=100, nullable=true)
     */
    private $numeroOficioLevantamiento;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones_levantamiento", type="text", nullable=true)
     */
    private $observacionesLevantamiento;

    /** @ORM\ManyToOne(targetEntity="UserCiudadano", inversedBy="medidasCautelares") */
    private $ciudadano;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloCfgLimitacionCausal", inversedBy="medidasCautelares")
     **/
    protected $causal;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloCfgLimitacionTipoProceso", inversedBy="medidasCautelares")
     **/
    protected $tipoProceso;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgEntidadJudicial", inversedBy="medidasCautelares")
     **/
    protected $entidadJudicial;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgMunicipio", inversedBy="medidasCautelaress")
     **/
    protected $municipio;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgEntidadJudicial", inversedBy="medidasCautelares")
     **/
    protected $entidadJudicialLevantamiento;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgMunicipio", inversedBy="medidasCautelaress")
     **/
    protected $municipioLevantamiento;


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
     * Set numeroOficio
     *
     * @param string $numeroOficio
     *
     * @return UserMedidaCautelar
     */
    public function setNumeroOficio($numeroOficio)
    {
        $this->numeroOficio = $numeroOficio;

        return $this;
    }

    /**
     * Get numeroOficio
     *
     * @return string
     */
    public function getNumeroOficio()
    {
        return $this->numeroOficio;
    }

    /**
     * Set numeroRadicado
     *
     * @param string $numeroRadicado
     *
     * @return UserMedidaCautelar
     */
    public function setNumeroRadicado($numeroRadicado)
    {
        $this->numeroRadicado = $numeroRadicado;

        return $this;
    }

    /**
     * Get numeroRadicado
     *
     * @return string
     */
    public function getNumeroRadicado()
    {
        return $this->numeroRadicado;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return UserMedidaCautelar
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
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     *
     * @return UserMedidaCautelar
     */
    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;

        return $this;
    }

    /**
     * Get fechaRegistro
     *
     * @return \DateTime
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    /**
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     *
     * @return UserMedidaCautelar
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return \DateTime
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * Set fechaExpiracion
     *
     * @param \DateTime $fechaExpiracion
     *
     * @return UserMedidaCautelar
     */
    public function setFechaExpiracion($fechaExpiracion)
    {
        $this->fechaExpiracion = $fechaExpiracion;

        return $this;
    }

    /**
     * Get fechaExpiracion
     *
     * @return \DateTime
     */
    public function getFechaExpiracion()
    {
        return $this->fechaExpiracion;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return UserMedidaCautelar
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
     * Set fechaLevantamiento
     *
     * @param \DateTime $fechaLevantamiento
     *
     * @return UserMedidaCautelar
     */
    public function setFechaLevantamiento($fechaLevantamiento)
    {
        $this->fechaLevantamiento = $fechaLevantamiento;

        return $this;
    }

    /**
     * Get fechaLevantamiento
     *
     * @return \DateTime
     */
    public function getFechaLevantamiento()
    {
        return $this->fechaLevantamiento;
    }

    /**
     * Set numeroOficioLevantamiento
     *
     * @param string $numeroOficioLevantamiento
     *
     * @return UserMedidaCautelar
     */
    public function setNumeroOficioLevantamiento($numeroOficioLevantamiento)
    {
        $this->numeroOficioLevantamiento = $numeroOficioLevantamiento;

        return $this;
    }

    /**
     * Get numeroOficioLevantamiento
     *
     * @return string
     */
    public function getNumeroOficioLevantamiento()
    {
        return $this->numeroOficioLevantamiento;
    }

    /**
     * Set observacionesLevantamiento
     *
     * @param string $observacionesLevantamiento
     *
     * @return UserMedidaCautelar
     */
    public function setObservacionesLevantamiento($observacionesLevantamiento)
    {
        $this->observacionesLevantamiento = $observacionesLevantamiento;

        return $this;
    }

    /**
     * Get observacionesLevantamiento
     *
     * @return string
     */
    public function getObservacionesLevantamiento()
    {
        return $this->observacionesLevantamiento;
    }

    /**
     * Set ciudadano
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserCiudadano $ciudadano
     *
     * @return UserMedidaCautelar
     */
    public function setCiudadano(\JHWEB\UsuarioBundle\Entity\UserCiudadano $ciudadano = null)
    {
        $this->ciudadano = $ciudadano;

        return $this;
    }

    /**
     * Get ciudadano
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserCiudadano
     */
    public function getCiudadano()
    {
        return $this->ciudadano;
    }

    /**
     * Set causal
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgLimitacionCausal $causal
     *
     * @return UserMedidaCautelar
     */
    public function setCausal(\JHWEB\VehiculoBundle\Entity\VhloCfgLimitacionCausal $causal = null)
    {
        $this->causal = $causal;

        return $this;
    }

    /**
     * Get causal
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgLimitacionCausal
     */
    public function getCausal()
    {
        return $this->causal;
    }

    /**
     * Set tipoProceso
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgLimitacionTipoProceso $tipoProceso
     *
     * @return UserMedidaCautelar
     */
    public function setTipoProceso(\JHWEB\VehiculoBundle\Entity\VhloCfgLimitacionTipoProceso $tipoProceso = null)
    {
        $this->tipoProceso = $tipoProceso;

        return $this;
    }

    /**
     * Get tipoProceso
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgLimitacionTipoProceso
     */
    public function getTipoProceso()
    {
        return $this->tipoProceso;
    }

    /**
     * Set entidadJudicial
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgEntidadJudicial $entidadJudicial
     *
     * @return UserMedidaCautelar
     */
    public function setEntidadJudicial(\JHWEB\ConfigBundle\Entity\CfgEntidadJudicial $entidadJudicial = null)
    {
        $this->entidadJudicial = $entidadJudicial;

        return $this;
    }

    /**
     * Get entidadJudicial
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgEntidadJudicial
     */
    public function getEntidadJudicial()
    {
        return $this->entidadJudicial;
    }

    /**
     * Set municipio
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgMunicipio $municipio
     *
     * @return UserMedidaCautelar
     */
    public function setMunicipio(\JHWEB\ConfigBundle\Entity\CfgMunicipio $municipio = null)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgMunicipio
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * Set entidadJudicialLevantamiento
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgEntidadJudicial $entidadJudicialLevantamiento
     *
     * @return UserMedidaCautelar
     */
    public function setEntidadJudicialLevantamiento(\JHWEB\ConfigBundle\Entity\CfgEntidadJudicial $entidadJudicialLevantamiento = null)
    {
        $this->entidadJudicialLevantamiento = $entidadJudicialLevantamiento;

        return $this;
    }

    /**
     * Get entidadJudicialLevantamiento
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgEntidadJudicial
     */
    public function getEntidadJudicialLevantamiento()
    {
        return $this->entidadJudicialLevantamiento;
    }

    /**
     * Set municipioLevantamiento
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgMunicipio $municipioLevantamiento
     *
     * @return UserMedidaCautelar
     */
    public function setMunicipioLevantamiento(\JHWEB\ConfigBundle\Entity\CfgMunicipio $municipioLevantamiento = null)
    {
        $this->municipioLevantamiento = $municipioLevantamiento;

        return $this;
    }

    /**
     * Get municipioLevantamiento
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgMunicipio
     */
    public function getMunicipioLevantamiento()
    {
        return $this->municipioLevantamiento;
    }
}
