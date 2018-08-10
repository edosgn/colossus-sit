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
     * @ORM\Column(name="grado_alchohol", type="integer", nullable=true)
     */
    private $gradoAlchohol;

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
    protected $cuidadanoInfractor;

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
    protected $cuidadanoTestigo;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CfgComparendoEstado", inversedBy="comparendos")
     **/
    protected $estado;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MflInfraccion", inversedBy="comparendos")
     **/
    protected $infraccion;

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
        return $this->fechaNotificacion;
    }

    /**
     * Set gradoAlchohol
     *
     * @param integer $gradoAlchohol
     *
     * @return Comparendo
     */
    public function setGradoAlchohol($gradoAlchohol)
    {
        $this->gradoAlchohol = $gradoAlchohol;

        return $this;
    }

    /**
     * Get gradoAlchohol
     *
     * @return integer
     */
    public function getGradoAlchohol()
    {
        return $this->gradoAlchohol;
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
     * Set cuidadanoInfractor
     *
     * @param \AppBundle\Entity\Ciudadano $cuidadanoInfractor
     *
     * @return Comparendo
     */
    public function setCuidadanoInfractor(\AppBundle\Entity\Ciudadano $cuidadanoInfractor = null)
    {
        $this->cuidadanoInfractor = $cuidadanoInfractor;

        return $this;
    }

    /**
     * Get cuidadanoInfractor
     *
     * @return \AppBundle\Entity\Ciudadano
     */
    public function getCuidadanoInfractor()
    {
        return $this->cuidadanoInfractor;
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
     * Set cuidadanoTestigo
     *
     * @param \AppBundle\Entity\Ciudadano $cuidadanoTestigo
     *
     * @return Comparendo
     */
    public function setCuidadanoTestigo(\AppBundle\Entity\Ciudadano $cuidadanoTestigo = null)
    {
        $this->cuidadanoTestigo = $cuidadanoTestigo;

        return $this;
    }

    /**
     * Get cuidadanoTestigo
     *
     * @return \AppBundle\Entity\Ciudadano
     */
    public function getCuidadanoTestigo()
    {
        return $this->cuidadanoTestigo;
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
}
