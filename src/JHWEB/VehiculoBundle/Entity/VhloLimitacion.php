<?php

namespace JHWEB\VehiculoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VhloLimitacion
 *
 * @ORM\Table(name="vhlo_limitacion")
 * @ORM\Entity(repositoryClass="JHWEB\VehiculoBundle\Repository\VhloLimitacionRepository")
 */
class VhloLimitacion
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
     * @ORM\Column(name="fechaRadicacion", type="date")
     */
    private $fechaRadicacion;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroOrdenJudicial", type="string", length=45)
     */
    private $numeroOrdenJudicial;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaExpedicion", type="date")
     */
    private $fechaExpedicion;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", length=255)
     */
    private $observaciones;
    
    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgEntidadJudicial", inversedBy="limitaciones")
     **/
    protected $entidadJudicial;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgMunicipio", inversedBy="limitaciones")
     **/
    protected $municipio;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserCiudadano", inversedBy="limitaciones")
     **/
    protected $demandado;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserCiudadano", inversedBy="limitaciones")
     **/
    protected $demandante;

    /**
     * @ORM\ManyToOne(targetEntity="VhloCfgLimitacionTipo", inversedBy="limitaciones")
     **/
    protected $tipo;

    /**
     * @ORM\ManyToOne(targetEntity="VhloCfgLimitacionCausal", inversedBy="limitaciones")
     **/
    protected $causal;

    /**
     * @ORM\ManyToOne(targetEntity="VhloCfgLimitacionTipoProceso", inversedBy="limitaciones")
     **/
    protected $tipoProceso;

    /**
     * @ORM\ManyToOne(targetEntity="VhloVehiculo", inversedBy="limitaciones")
     **/
    protected $vehiculo;

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
     * Set fechaRadicacion
     *
     * @param \DateTime $fechaRadicacion
     *
     * @return VhloLimitacion
     */
    public function setFechaRadicacion($fechaRadicacion)
    {
        $this->fechaRadicacion = $fechaRadicacion;

        return $this;
    }

    /**
     * Get fechaRadicacion
     *
     * @return \DateTime
     */
    public function getFechaRadicacion()
    {
        return $this->fechaRadicacion;
    }

    /**
     * Set numeroOrdenJudicial
     *
     * @param string $numeroOrdenJudicial
     *
     * @return VhloLimitacion
     */
    public function setNumeroOrdenJudicial($numeroOrdenJudicial)
    {
        $this->numeroOrdenJudicial = $numeroOrdenJudicial;

        return $this;
    }

    /**
     * Get numeroOrdenJudicial
     *
     * @return string
     */
    public function getNumeroOrdenJudicial()
    {
        return $this->numeroOrdenJudicial;
    }

    /**
     * Set fechaExpedicion
     *
     * @param \DateTime $fechaExpedicion
     *
     * @return VhloLimitacion
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
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return VhloLimitacion
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
     * @return VhloLimitacion
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
     * Set entidadJudicial
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgEntidadJudicial $entidadJudicial
     *
     * @return VhloLimitacion
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
     * @return VhloLimitacion
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
     * Set demandado
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserCiudadano $demandado
     *
     * @return VhloLimitacion
     */
    public function setDemandado(\JHWEB\UsuarioBundle\Entity\UserCiudadano $demandado = null)
    {
        $this->demandado = $demandado;

        return $this;
    }

    /**
     * Get demandado
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserCiudadano
     */
    public function getDemandado()
    {
        return $this->demandado;
    }

    /**
     * Set demandante
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserCiudadano $demandante
     *
     * @return VhloLimitacion
     */
    public function setDemandante(\JHWEB\UsuarioBundle\Entity\UserCiudadano $demandante = null)
    {
        $this->demandante = $demandante;

        return $this;
    }

    /**
     * Get demandante
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserCiudadano
     */
    public function getDemandante()
    {
        return $this->demandante;
    }

    /**
     * Set tipo
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgLimitacionTipo $tipo
     *
     * @return VhloLimitacion
     */
    public function setTipo(\JHWEB\VehiculoBundle\Entity\VhloCfgLimitacionTipo $tipo = null)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgLimitacionTipo
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set causal
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgLimitacionCausal $causal
     *
     * @return VhloLimitacion
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
     * @return VhloLimitacion
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
     * Set vehiculo
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloVehiculo $vehiculo
     *
     * @return VhloLimitacion
     */
    public function setVehiculo(\JHWEB\VehiculoBundle\Entity\VhloVehiculo $vehiculo = null)
    {
        $this->vehiculo = $vehiculo;

        return $this;
    }

    /**
     * Get vehiculo
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloVehiculo
     */
    public function getVehiculo()
    {
        return $this->vehiculo;
    }
}
