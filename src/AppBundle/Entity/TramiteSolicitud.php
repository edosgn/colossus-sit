<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TramiteSolicitud
 *
 * @ORM\Table(name="tramite_solicitud")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TramiteSolicitudRepository")
 */
class TramiteSolicitud
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
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="text", nullable=true)
     */
    private $observacion;

    /**
     * @var bool
     *
     * @ORM\Column(name="documentacion", type="boolean")
     */
    private $documentacion = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado = true;

    /**
     * @var array
     *
     * @ORM\Column(name="datos", type="array", nullable=true)
     */
    private $datos;

    /**
     * @var array
     *
     * @ORM\Column(name="resumen", type="array", nullable=true)
     */
    private $resumen;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TramiteFactura", inversedBy="tramitesSolicitud")
     **/
    protected $tramiteFactura;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PropietarioVehiculo", inversedBy="tramitesSolicitud")
     **/
    protected $solicitante;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ciudadano", inversedBy="tramitesSolicitud")
     **/
    protected $ciudadano;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehiculo", inversedBy="tramitesSolicitud")
     **/
    protected $vehiculo;


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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return TramiteSolicitud
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
     * Set observacion
     *
     * @param string $observacion
     *
     * @return TramiteSolicitud
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
     * Set documentacion
     *
     * @param boolean $documentacion
     *
     * @return TramiteSolicitud
     */
    public function setDocumentacion($documentacion)
    {
        $this->documentacion = $documentacion;

        return $this;
    }

    /**
     * Get documentacion
     *
     * @return boolean
     */
    public function getDocumentacion()
    {
        return $this->documentacion;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return TramiteSolicitud
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set datos
     *
     * @param array $datos
     *
     * @return TramiteSolicitud
     */
    public function setDatos($datos)
    {
        $this->datos = $datos;

        return $this;
    }

    /**
     * Get datos
     *
     * @return array
     */
    public function getDatos()
    {
        return $this->datos;
    }

    /**
     * Set resumen
     *
     * @param array $resumen
     *
     * @return TramiteSolicitud
     */
    public function setResumen($resumen)
    {
        $this->resumen = $resumen;

        return $this;
    }

    /**
     * Get resumen
     *
     * @return array
     */
    public function getResumen()
    {
        return $this->resumen;
    }

    /**
     * Set tramiteFactura
     *
     * @param \AppBundle\Entity\TramiteFactura $tramiteFactura
     *
     * @return TramiteSolicitud
     */
    public function setTramiteFactura(\AppBundle\Entity\TramiteFactura $tramiteFactura = null)
    {
        $this->tramiteFactura = $tramiteFactura;

        return $this;
    }

    /**
     * Get tramiteFactura
     *
     * @return \AppBundle\Entity\TramiteFactura
     */
    public function getTramiteFactura()
    {
        return $this->tramiteFactura;
    }

    /**
     * Set solicitante
     *
     * @param \AppBundle\Entity\PropietarioVehiculo $solicitante
     *
     * @return TramiteSolicitud
     */
    public function setSolicitante(\AppBundle\Entity\PropietarioVehiculo $solicitante = null)
    {
        $this->solicitante = $solicitante;

        return $this;
    }

    /**
     * Get solicitante
     *
     * @return \AppBundle\Entity\PropietarioVehiculo
     */
    public function getSolicitante()
    {
        return $this->solicitante;
    }

    /**
     * Set ciudadano
     *
     * @param \AppBundle\Entity\Ciudadano $ciudadano
     *
     * @return TramiteSolicitud
     */
    public function setCiudadano(\AppBundle\Entity\Ciudadano $ciudadano = null)
    {
        $this->ciudadano = $ciudadano;

        return $this;
    }

    /**
     * Get ciudadano
     *
     * @return \AppBundle\Entity\Ciudadano
     */
    public function getCiudadano()
    {
        return $this->ciudadano;
    }

    /**
     * Set vehiculo
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculo
     *
     * @return TramiteSolicitud
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
