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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora", type="time", nullable=true)
     */
    private $hora;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255, nullable=true)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="localidad", type="string", length=255, nullable=true)
     */
    private $localidad;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_licencia_transito", type="string", length=255, nullable=true)
     */
    private $numeroLicenciaTransito;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones_agente", type="text", nullable=true)
     */
    private $observacionesAgente;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones_digitador", type="text", nullable=true)
     */
    private $observacionesDigitador;

    /**
     * @var bool
     *
     * @ORM\Column(name="inmovilizacion", type="boolean", nullable=true)
     */
    private $inmovilizacion;

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
     * @ORM\Column(name="retencion_licencia", type="boolean", nullable=true)
     */
    private $retencionLicencia;

    /**
     * @var bool
     *
     * @ORM\Column(name="fotomulta", type="boolean", nullable=true)
     */
    private $fotomulta;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_notificacion", type="date", nullable=true)
     */
    private $fechaNotificacion;

    /**
     * @var int
     *
     * @ORM\Column(name="grado_alcohol", type="integer", nullable=true)
     */
    private $gradoAlcohol;

    /**
     * @var int
     *
     * @ORM\Column(name="valor_infraccion", type="integer", nullable=true)
     */
    private $valorInfraccion;

    /**
     * @var int
     *
     * @ORM\Column(name="valor_adicional", type="integer", nullable=true)
     */
    private $valorAdicional;

    /**
     * @var string
     *
     * @ORM\Column(name="url_documento", type="string", nullable=true)
     */
    private $urlDocumento;

    /**
     * @var bool
     *
     * @ORM\Column(name="polca", type="boolean", nullable=true)
     */
    private $polca = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo = true;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MpersonalFuncionario", inversedBy="comparendos")
     **/
    protected $agenteTransito;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MpersonalComparendo", inversedBy="comparendos")
     **/
    protected $consecutivo;

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
    protected $ciudadanoInfractor;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CfgTipoInfractor", inversedBy="comparendos")
     **/
    protected $tipoInfractor;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\LicenciaConduccion", inversedBy="comparendos")
     **/
    protected $licenciaConduccion;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ciudadano", inversedBy="comparendos")
     **/
    protected $ciudadanoTestigo;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CfgComparendoEstado", inversedBy="comparendos")
     **/
    protected $estado;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MflInfraccion", inversedBy="comparendos")
     **/
    protected $infraccion;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CfgTipoVehiculo", inversedBy="tipos")
     **/
    protected $tipoVehiculo;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ContravencionalBundle\Entity\CvAcuerdoPago", inversedBy="comparendos")
     **/
    protected $acuerdoPago;

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
     * @return Comparendo
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
        if ($this->fecha) {
            return $this->fecha->format('d/m/Y');
        }
        return $this->fecha;
    }

    /**
     * Set hora
     *
     * @param \DateTime $hora
     *
     * @return Comparendo
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
        if ($this->hora) {
            return $this->hora->format('H:m');
        }
        return $this->hora;

    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Comparendo
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set localidad
     *
     * @param string $localidad
     *
     * @return Comparendo
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad
     *
     * @return string
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * Set numeroLicenciaTransito
     *
     * @param string $numeroLicenciaTransito
     *
     * @return Comparendo
     */
    public function setNumeroLicenciaTransito($numeroLicenciaTransito)
    {
        $this->numeroLicenciaTransito = $numeroLicenciaTransito;

        return $this;
    }

    /**
     * Get numeroLicenciaTransito
     *
     * @return string
     */
    public function getNumeroLicenciaTransito()
    {
        return $this->numeroLicenciaTransito;
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
     * Set inmovilizacion
     *
     * @param boolean $inmovilizacion
     *
     * @return Comparendo
     */
    public function setInmovilizacion($inmovilizacion)
    {
        $this->inmovilizacion = $inmovilizacion;

        return $this;
    }

    /**
     * Get inmovilizacion
     *
     * @return boolean
     */
    public function getInmovilizacion()
    {
        return $this->inmovilizacion;
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
        if ($this->fechaNotificacion) {
            return $this->fechaNotificacion->format('d/m/Y');
        }
        return $this->fechaNotificacion;
    }

    /**
     * Set gradoAlcohol
     *
     * @param integer $gradoAlcohol
     *
     * @return Comparendo
     */
    public function setGradoAlcohol($gradoAlcohol)
    {
        $this->gradoAlcohol = $gradoAlcohol;

        return $this;
    }

    /**
     * Get gradoAlcohol
     *
     * @return integer
     */
    public function getGradoAlcohol()
    {
        return $this->gradoAlcohol;
    }

    /**
     * Set valorInfraccion
     *
     * @param integer $valorInfraccion
     *
     * @return Comparendo
     */
    public function setValorInfraccion($valorInfraccion)
    {
        $this->valorInfraccion = $valorInfraccion;

        return $this;
    }

    /**
     * Get valorInfraccion
     *
     * @return integer
     */
    public function getValorInfraccion()
    {
        return $this->valorInfraccion;
    }

    /**
     * Set valorAdicional
     *
     * @param integer $valorAdicional
     *
     * @return Comparendo
     */
    public function setValorAdicional($valorAdicional)
    {
        $this->valorAdicional = $valorAdicional;

        return $this;
    }

    /**
     * Get valorAdicional
     *
     * @return integer
     */
    public function getValorAdicional()
    {
        return $this->valorAdicional;
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Comparendo
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
     * Set consecutivo
     *
     * @param \AppBundle\Entity\MpersonalComparendo $consecutivo
     *
     * @return Comparendo
     */
    public function setConsecutivo(\AppBundle\Entity\MpersonalComparendo $consecutivo = null)
    {
        $this->consecutivo = $consecutivo;

        return $this;
    }

    /**
     * Get consecutivo
     *
     * @return \AppBundle\Entity\MpersonalComparendo
     */
    public function getConsecutivo()
    {
        return $this->consecutivo;
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
     * Set ciudadanoInfractor
     *
     * @param \AppBundle\Entity\Ciudadano $ciudadanoInfractor
     *
     * @return Comparendo
     */
    public function setCiudadanoInfractor(\AppBundle\Entity\Ciudadano $ciudadanoInfractor = null)
    {
        $this->ciudadanoInfractor = $ciudadanoInfractor;

        return $this;
    }

    /**
     * Get ciudadanoInfractor
     *
     * @return \AppBundle\Entity\Ciudadano
     */
    public function getCiudadanoInfractor()
    {
        return $this->ciudadanoInfractor;
    }

    /**
     * Set tipoInfractor
     *
     * @param \AppBundle\Entity\CfgTipoInfractor $tipoInfractor
     *
     * @return Comparendo
     */
    public function setTipoInfractor(\AppBundle\Entity\CfgTipoInfractor $tipoInfractor = null)
    {
        $this->tipoInfractor = $tipoInfractor;

        return $this;
    }

    /**
     * Get tipoInfractor
     *
     * @return \AppBundle\Entity\CfgTipoInfractor
     */
    public function getTipoInfractor()
    {
        return $this->tipoInfractor;
    }

    /**
     * Set licenciaConduccion
     *
     * @param \AppBundle\Entity\LicenciaConduccion $licenciaConduccion
     *
     * @return Comparendo
     */
    public function setLicenciaConduccion(\AppBundle\Entity\LicenciaConduccion $licenciaConduccion = null)
    {
        $this->licenciaConduccion = $licenciaConduccion;

        return $this;
    }

    /**
     * Get licenciaConduccion
     *
     * @return \AppBundle\Entity\LicenciaConduccion
     */
    public function getLicenciaConduccion()
    {
        return $this->licenciaConduccion;
    }

    /**
     * Set ciudadanoTestigo
     *
     * @param \AppBundle\Entity\Ciudadano $ciudadanoTestigo
     *
     * @return Comparendo
     */
    public function setCiudadanoTestigo(\AppBundle\Entity\Ciudadano $ciudadanoTestigo = null)
    {
        $this->ciudadanoTestigo = $ciudadanoTestigo;

        return $this;
    }

    /**
     * Get ciudadanoTestigo
     *
     * @return \AppBundle\Entity\Ciudadano
     */
    public function getCiudadanoTestigo()
    {
        return $this->ciudadanoTestigo;
    }

    /**
     * Set estado
     *
     * @param \AppBundle\Entity\CfgComparendoEstado $estado
     *
     * @return Comparendo
     */
    public function setEstado(\AppBundle\Entity\CfgComparendoEstado $estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \AppBundle\Entity\CfgComparendoEstado
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set infraccion
     *
     * @param \AppBundle\Entity\MflInfraccion $infraccion
     *
     * @return Comparendo
     */
    public function setInfraccion(\AppBundle\Entity\MflInfraccion $infraccion = null)
    {
        $this->infraccion = $infraccion;

        return $this;
    }

    /**
     * Get infraccion
     *
     * @return \AppBundle\Entity\MflInfraccion
     */
    public function getInfraccion()
    {
        return $this->infraccion;
    }

    /**
     * Set tipoVehiculo
     *
     * @param \AppBundle\Entity\CfgTipoVehiculo $tipoVehiculo
     *
     * @return Comparendo
     */
    public function setTipoVehiculo(\AppBundle\Entity\CfgTipoVehiculo $tipoVehiculo = null)
    {
        $this->tipoVehiculo = $tipoVehiculo;

        return $this;
    }

    /**
     * Get tipoVehiculo
     *
     * @return \AppBundle\Entity\CfgTipoVehiculo
     */
    public function getTipoVehiculo()
    {
        return $this->tipoVehiculo;
    }

    /**
     * Set acuerdoPago
     *
     * @param \JHWEB\ContravencionalBundle\Entity\CvAcuerdoPago $acuerdoPago
     *
     * @return Comparendo
     */
    public function setAcuerdoPago(\JHWEB\ContravencionalBundle\Entity\CvAcuerdoPago $acuerdoPago = null)
    {
        $this->acuerdoPago = $acuerdoPago;

        return $this;
    }

    /**
     * Get acuerdoPago
     *
     * @return \JHWEB\ContravencionalBundle\Entity\CvAcuerdoPago
     */
    public function getAcuerdoPago()
    {
        return $this->acuerdoPago;
    }
}
