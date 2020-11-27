<?php

namespace JHWEB\FinancieroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FroTrteCarpeta
 *
 * @ORM\Table(name="fro_trte_carpeta")
 * @ORM\Entity(repositoryClass="JHWEB\FinancieroBundle\Repository\FroTrteCarpetaRepository")
 */
class FroTrteCarpeta
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
     * @ORM\Column(name="valor", type="integer", nullable=true)
     */
    private $valor;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_realizacion", type="date", nullable=true)
     */
    private $fechaRealizacion;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="date", nullable=true)
     */
    private $createdAt;
    
    /**
     * @var array
     *
     * @ORM\Column(name="foraneas", type="array", nullable=true)
     */
    private $foraneas;

    /**
     * @var string
     *
     * @ORM\Column(name="resumen", type="text", nullable=true)
     */
    private $resumen;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserCiudadano", inversedBy="carpetas")
     **/
    protected $ciudadano;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserCiudadano", inversedBy="carpetas")
     **/
    protected $solicitante;
    
    /** @ORM\ManyToOne(targetEntity="FroTramite", inversedBy="carpeta") */
    private $tramite;
    
    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloVehiculo", inversedBy="carpeta")
     **/
    protected $vehiculo;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgOrganismoTransito", inversedBy="carpeta")
     **/
    protected $organismoTransito;

    /** @ORM\PrePersist */
    public function setCreatedAt()
    {
        $this->createdAt = new \DateTime('now');
    }

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
     * Set valor
     *
     * @param integer $valor
     *
     * @return FroTrteCarpeta
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set fechaRealizacion
     *
     * @param \DateTime $fechaRealizacion
     *
     * @return FroTrteCarpeta
     */
    public function setFechaRealizacion($fechaRealizacion)
    {
        $this->fechaRealizacion = $fechaRealizacion;

        return $this;
    }

    /**
     * Get fechaRealizacion
     *
     * @return \DateTime
     */
    public function getFechaRealizacion()
    {
        return $this->fechaRealizacion;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set foraneas
     *
     * @param array $foraneas
     *
     * @return FroTrteCarpeta
     */
    public function setForaneas($foraneas)
    {
        $this->foraneas = $foraneas;

        return $this;
    }

    /**
     * Get foraneas
     *
     * @return array
     */
    public function getForaneas()
    {
        return $this->foraneas;
    }

    /**
     * Set resumen
     *
     * @param string $resumen
     *
     * @return FroTrteCarpeta
     */
    public function setResumen($resumen)
    {
        $this->resumen = $resumen;

        return $this;
    }

    /**
     * Get resumen
     *
     * @return string
     */
    public function getResumen()
    {
        return $this->resumen;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return FroTrteCarpeta
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
     * Set ciudadano
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserCiudadano $ciudadano
     *
     * @return FroTrteCarpeta
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
     * Set solicitante
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserCiudadano $solicitante
     *
     * @return FroTrteCarpeta
     */
    public function setSolicitante(\JHWEB\UsuarioBundle\Entity\UserCiudadano $solicitante = null)
    {
        $this->solicitante = $solicitante;

        return $this;
    }

    /**
     * Get solicitante
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserCiudadano
     */
    public function getSolicitante()
    {
        return $this->solicitante;
    }

    /**
     * Set tramite
     *
     * @param \JHWEB\FinancieroBundle\Entity\FroTramite $tramite
     *
     * @return FroTrteCarpeta
     */
    public function setTramite(\JHWEB\FinancieroBundle\Entity\FroTramite $tramite = null)
    {
        $this->tramite = $tramite;

        return $this;
    }

    /**
     * Get tramite
     *
     * @return \JHWEB\FinancieroBundle\Entity\FroTramite
     */
    public function getTramite()
    {
        return $this->tramite;
    }

    /**
     * Set vehiculo
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloVehiculo $vehiculo
     *
     * @return FroTrteCarpeta
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

    /**
     * Set organismoTransito
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgOrganismoTransito $organismoTransito
     *
     * @return FroTrteCarpeta
     */
    public function setOrganismoTransito(\JHWEB\ConfigBundle\Entity\CfgOrganismoTransito $organismoTransito = null)
    {
        $this->organismoTransito = $organismoTransito;

        return $this;
    }

    /**
     * Get organismoTransito
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgOrganismoTransito
     */
    public function getOrganismoTransito()
    {
        return $this->organismoTransito;
    }
}
