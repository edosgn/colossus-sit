<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comparendo
 *
 * @ORM\Table(name="comparendo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ComparendoRepository")
 */
class Comparendo
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
     * @ORM\Column(name="numeroOrden", type="string", length=45)
     */
    private $numeroOrden;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaDiligenciamiento", type="datetime", nullable=true)
     */
    private $fechaDiligenciamiento;

    /**
     * @var string
     *
     * @ORM\Column(name="lugarInfraccion", type="string", length=255, nullable=true)
     */
    private $lugarInfraccion;

    /**
     * @var string
     *
     * @ORM\Column(name="barrioInfraccion", type="string", length=45, nullable=true)
     */
    private $barrioInfraccion;

    /**
     * @var string
     *
     * @ORM\Column(name="observacionesAgente", type="text", nullable=true)
     */
    private $observacionesAgente;

    /**
     * @var string
     *
     * @ORM\Column(name="observacionesDigitador", type="text", nullable=true)
     */
    private $observacionesDigitador;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoInfractor", type="string", length=45, nullable=true)
     */
    private $tipoInfractor;

    /**
     * @var int
     *
     * @ORM\Column(name="tarjetaOperacionInfractor", type="integer", nullable=true)
     */
    private $tarjetaOperacionInfractor;

    /**
     * @var bool
     *
     * @ORM\Column(name="fuga", type="boolean", nullable=true)
     */
    private $fuga;

    /**
     * @var bool
     *
     * @ORM\Column(name="accidente", type="boolean", nullable=true)
     */
    private $accidente;

    /**
     * @var bool
     *
     * @ORM\Column(name="polca", type="boolean", nullable=true)
     */
    private $polca;

    /**
     * @var bool
     *
     * @ORM\Column(name="fotomulta", type="boolean", nullable=true)
     */
    private $fotomulta;

    /**
     * @var bool
     *
     * @ORM\Column(name="retencionLicencia", type="boolean", nullable=true)
     */
    private $retencionLicencia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaNotificacion", type="date", nullable=true)
     */
    private $fechaNotificacion;

    /**
     * @var int
     *
     * @ORM\Column(name="gradoAlchoholemia", type="integer", nullable=true)
     */
    private $gradoAlchoholemia;

    /**
     * @var string
     *
     * @ORM\Column(name="urlDocumento", type="string", nullable=true)
     */
    private $urlDocumento;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado = true;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Municipio", inversedBy="comparendos")
     **/
    protected $municipio;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehiculo", inversedBy="comparendos")
     **/
    protected $vehiculo;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ciudadano", inversedBy="comparendos")
     **/
    protected $cuidadano;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MpersonalFuncionario", inversedBy="comparendos")
     **/
    protected $agenteTransito;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SeguimientoEntrega", inversedBy="comparendos")
     **/
    protected $seguimientoEntrega;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Factura", inversedBy="comparendos")
     **/
    protected $factura;
    

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
     * Set numeroOrden
     *
     * @param string $numeroOrden
     *
     * @return Comparendo
     */
    public function setNumeroOrden($numeroOrden)
    {
        $this->numeroOrden = $numeroOrden;

        return $this;
    }

    /**
     * Get numeroOrden
     *
     * @return string
     */
    public function getNumeroOrden()
    {
        return $this->numeroOrden;
    }

    /**
     * Set fechaDiligenciamiento
     *
     * @param \DateTime $fechaDiligenciamiento
     *
     * @return Comparendo
     */
    public function setFechaDiligenciamiento($fechaDiligenciamiento)
    {
        $this->fechaDiligenciamiento = $fechaDiligenciamiento;

        return $this;
    }

    /**
     * Get fechaDiligenciamiento
     *
     * @return \DateTime
     */
    public function getFechaDiligenciamiento()
    {
        return $this->fechaDiligenciamiento;
    }

    /**
     * Set lugarInfraccion
     *
     * @param string $lugarInfraccion
     *
     * @return Comparendo
     */
    public function setLugarInfraccion($lugarInfraccion)
    {
        $this->lugarInfraccion = $lugarInfraccion;

        return $this;
    }

    /**
     * Get lugarInfraccion
     *
     * @return string
     */
    public function getLugarInfraccion()
    {
        return $this->lugarInfraccion;
    }

    /**
     * Set barrioInfraccion
     *
     * @param string $barrioInfraccion
     *
     * @return Comparendo
     */
    public function setBarrioInfraccion($barrioInfraccion)
    {
        $this->barrioInfraccion = $barrioInfraccion;

        return $this;
    }

    /**
     * Get barrioInfraccion
     *
     * @return string
     */
    public function getBarrioInfraccion()
    {
        return $this->barrioInfraccion;
    }

    /**
     * Set observacionesAgente
     *
     * @param string $observacionesAgente
     *
     * @return Comparendo
     */
    public function setObservacionesAgente($observacionesAgente)
    {
        $this->observacionesAgente = $observacionesAgente;

        return $this;
    }

    /**
     * Get observacionesAgente
     *
     * @return string
     */
    public function getObservacionesAgente()
    {
        return $this->observacionesAgente;
    }

    /**
     * Set observacionesDigitador
     *
     * @param string $observacionesDigitador
     *
     * @return Comparendo
     */
    public function setObservacionesDigitador($observacionesDigitador)
    {
        $this->observacionesDigitador = $observacionesDigitador;

        return $this;
    }

    /**
     * Get observacionesDigitador
     *
     * @return string
     */
    public function getObservacionesDigitador()
    {
        return $this->observacionesDigitador;
    }

    /**
     * Set tipoInfractor
     *
     * @param string $tipoInfractor
     *
     * @return Comparendo
     */
    public function setTipoInfractor($tipoInfractor)
    {
        $this->tipoInfractor = $tipoInfractor;

        return $this;
    }

    /**
     * Get tipoInfractor
     *
     * @return string
     */
    public function getTipoInfractor()
    {
        return $this->tipoInfractor;
    }

    /**
     * Set tarjetaOperacionInfractor
     *
     * @param integer $tarjetaOperacionInfractor
     *
     * @return Comparendo
     */
    public function setTarjetaOperacionInfractor($tarjetaOperacionInfractor)
    {
        $this->tarjetaOperacionInfractor = $tarjetaOperacionInfractor;

        return $this;
    }

    /**
     * Get tarjetaOperacionInfractor
     *
     * @return integer
     */
    public function getTarjetaOperacionInfractor()
    {
        return $this->tarjetaOperacionInfractor;
    }

    /**
     * Set fuga
     *
     * @param boolean $fuga
     *
     * @return Comparendo
     */
    public function setFuga($fuga)
    {
        $this->fuga = $fuga;

        return $this;
    }

    /**
     * Get fuga
     *
     * @return boolean
     */
    public function getFuga()
    {
        return $this->fuga;
    }

    /**
     * Set accidente
     *
     * @param boolean $accidente
     *
     * @return Comparendo
     */
    public function setAccidente($accidente)
    {
        $this->accidente = $accidente;

        return $this;
    }

    /**
     * Get accidente
     *
     * @return boolean
     */
    public function getAccidente()
    {
        return $this->accidente;
    }

    /**
     * Set polca
     *
     * @param boolean $polca
     *
     * @return Comparendo
     */
    public function setPolca($polca)
    {
        $this->polca = $polca;

        return $this;
    }

    /**
     * Get polca
     *
     * @return boolean
     */
    public function getPolca()
    {
        return $this->polca;
    }

    /**
     * Set fotomulta
     *
     * @param boolean $fotomulta
     *
     * @return Comparendo
     */
    public function setFotomulta($fotomulta)
    {
        $this->fotomulta = $fotomulta;

        return $this;
    }

    /**
     * Get fotomulta
     *
     * @return boolean
     */
    public function getFotomulta()
    {
        return $this->fotomulta;
    }

    /**
     * Set retencionLicencia
     *
     * @param boolean $retencionLicencia
     *
     * @return Comparendo
     */
    public function setRetencionLicencia($retencionLicencia)
    {
        $this->retencionLicencia = $retencionLicencia;

        return $this;
    }

    /**
     * Get retencionLicencia
     *
     * @return boolean
     */
    public function getRetencionLicencia()
    {
        return $this->retencionLicencia;
    }

    /**
     * Set fechaNotificacion
     *
     * @param \DateTime $fechaNotificacion
     *
     * @return Comparendo
     */
    public function setFechaNotificacion($fechaNotificacion)
    {
        $this->fechaNotificacion = $fechaNotificacion;

        return $this;
    }

    /**
     * Get fechaNotificacion
     *
     * @return \DateTime
     */
    public function getFechaNotificacion()
    {
        return $this->fechaNotificacion;
    }

    /**
     * Set gradoAlchoholemia
     *
     * @param integer $gradoAlchoholemia
     *
     * @return Comparendo
     */
    public function setGradoAlchoholemia($gradoAlchoholemia)
    {
        $this->gradoAlchoholemia = $gradoAlchoholemia;

        return $this;
    }

    /**
     * Get gradoAlchoholemia
     *
     * @return integer
     */
    public function getGradoAlchoholemia()
    {
        return $this->gradoAlchoholemia;
    }

    /**
     * Set urlDocumento
     *
     * @param string $urlDocumento
     *
     * @return Comparendo
     */
    public function setUrlDocumento($urlDocumento)
    {
        $this->urlDocumento = $urlDocumento;

        return $this;
    }

    /**
     * Get urlDocumento
     *
     * @return string
     */
    public function getUrlDocumento()
    {
        return $this->urlDocumento;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return Comparendo
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
     * Set municipio
     *
     * @param \AppBundle\Entity\Municipio $municipio
     *
     * @return Comparendo
     */
    public function setMunicipio(\AppBundle\Entity\Municipio $municipio = null)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return \AppBundle\Entity\Municipio
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * Set vehiculo
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculo
     *
     * @return Comparendo
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

    /**
     * Set cuidadano
     *
     * @param \AppBundle\Entity\Ciudadano $cuidadano
     *
     * @return Comparendo
     */
    public function setCuidadano(\AppBundle\Entity\Ciudadano $cuidadano = null)
    {
        $this->cuidadano = $cuidadano;

        return $this;
    }

    /**
     * Get cuidadano
     *
     * @return \AppBundle\Entity\Ciudadano
     */
    public function getCuidadano()
    {
        return $this->cuidadano;
    }

    /**
     * Set agenteTransito
     *
     * @param \AppBundle\Entity\MpersonalFuncionario $agenteTransito
     *
     * @return Comparendo
     */
    public function setAgenteTransito(\AppBundle\Entity\MpersonalFuncionario $agenteTransito = null)
    {
        $this->agenteTransito = $agenteTransito;

        return $this;
    }

    /**
     * Get agenteTransito
     *
     * @return \AppBundle\Entity\MpersonalFuncionario
     */
    public function getAgenteTransito()
    {
        return $this->agenteTransito;
    }

    /**
     * Set seguimientoEntrega
     *
     * @param \AppBundle\Entity\SeguimientoEntrega $seguimientoEntrega
     *
     * @return Comparendo
     */
    public function setSeguimientoEntrega(\AppBundle\Entity\SeguimientoEntrega $seguimientoEntrega = null)
    {
        $this->seguimientoEntrega = $seguimientoEntrega;

        return $this;
    }

    /**
     * Get seguimientoEntrega
     *
     * @return \AppBundle\Entity\SeguimientoEntrega
     */
    public function getSeguimientoEntrega()
    {
        return $this->seguimientoEntrega;
    }

    /**
     * Set factura
     *
     * @param \AppBundle\Entity\Factura $factura
     *
     * @return Comparendo
     */
    public function setFactura(\AppBundle\Entity\Factura $factura = null)
    {
        $this->factura = $factura;

        return $this;
    }

    /**
     * Get factura
     *
     * @return \AppBundle\Entity\Factura
     */
    public function getFactura()
    {
        return $this->factura;
    }
}
