<?php

namespace JHWEB\FinancieroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FroTrteSolicitud
 *
 * @ORM\Table(name="fro_trte_solicitud")
 * @ORM\Entity(repositoryClass="JHWEB\FinancieroBundle\Repository\FroTrteSolicitudRepository")
 */
class FroTrteSolicitud
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
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora", type="time")
     */
    private $hora;

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
     * @ORM\ManyToOne(targetEntity="FroFacTramite", inversedBy="tramitesSolicitud")
     **/
    protected $tramiteFactura;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloPropietario", inversedBy="tramitesSolicitud")
     **/
    protected $propietario;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserCiudadano", inversedBy="tramitesSolicitud")
     **/
    protected $solicitante;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloVehiculo", inversedBy="tramitesSolicitud")
     **/
    protected $vehiculo;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgOrganismoTransito", inversedBy="tramitesSolicitud")
     **/
    protected $organismoTransito;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\PersonalBundle\Entity\PnalFuncionario", inversedBy="tramitesSolicitud")
     **/
    protected $funcionario;


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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return FroTrteSolicitud
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set hora
     *
     * @param \DateTime $hora
     *
     * @return FroTrteSolicitud
     */
    public function setHora($hora)
    {
        $this->hora = $hora;

        return $this;
    }

    /**
     * Get hora
     *
     * @return \DateTime
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set foraneas
     *
     * @param array $foraneas
     *
     * @return FroTrteSolicitud
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
     * @return FroTrteSolicitud
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
        if ($this->resumen) {
            return htmlspecialchars(trim(strip_tags($this->resumen)));
        }
        return $this->resumen;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return FroTrteSolicitud
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
     * Set tramiteFactura
     *
     * @param \JHWEB\FinancieroBundle\Entity\FroFacTramite $tramiteFactura
     *
     * @return FroTrteSolicitud
     */
    public function setTramiteFactura(\JHWEB\FinancieroBundle\Entity\FroFacTramite $tramiteFactura = null)
    {
        $this->tramiteFactura = $tramiteFactura;

        return $this;
    }

    /**
     * Get tramiteFactura
     *
     * @return \JHWEB\FinancieroBundle\Entity\FroFacTramite
     */
    public function getTramiteFactura()
    {
        return $this->tramiteFactura;
    }

    /**
     * Set propietario
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloPropietario $propietario
     *
     * @return FroTrteSolicitud
     */
    public function setPropietario(\JHWEB\VehiculoBundle\Entity\VhloPropietario $propietario = null)
    {
        $this->propietario = $propietario;

        return $this;
    }

    /**
     * Get propietario
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloPropietario
     */
    public function getPropietario()
    {
        return $this->propietario;
    }

    /**
     * Set solicitante
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserCiudadano $solicitante
     *
     * @return FroTrteSolicitud
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
     * Set vehiculo
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloVehiculo $vehiculo
     *
     * @return FroTrteSolicitud
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
     * @return FroTrteSolicitud
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

    /**
     * Set funcionario
     *
     * @param \JHWEB\PersonalBundle\Entity\PnalFuncionario $funcionario
     *
     * @return FroTrteSolicitud
     */
    public function setFuncionario(\JHWEB\PersonalBundle\Entity\PnalFuncionario $funcionario = null)
    {
        $this->funcionario = $funcionario;

        return $this;
    }

    /**
     * Get funcionario
     *
     * @return \JHWEB\PersonalBundle\Entity\PnalFuncionario
     */
    public function getFuncionario()
    {
        return $this->funcionario;
    }
}
