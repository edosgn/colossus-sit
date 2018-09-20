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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Municipio", inversedBy="comparendos")
     **/
    protected $municipio;

    /**
     * @var string
     *
     * @ORM\Column(name="localidad", type="string", length=255, nullable=true)
     */
    private $localidad;
    
    /**
     * @var string
     *
     * @ORM\Column(name="placa", type="string", length=255, nullable=true)
     */
    private $placa;
    
    /**
     * @var string
     *
     * @ORM\Column(name="codigo_infraccion", type="string", length=255, nullable=true)
     */
    private $codigoInfraccion;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Municipio", inversedBy="municipios")
     **/
    protected $matriculadoEn;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Clase", inversedBy="clases")
     **/
    protected $clase;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Servicio", inversedBy="servicios")
     **/
    protected $servicio;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CfgRadioAccion", inversedBy="radioacciones")
     **/
    private $radioAccion;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\CfgModalidadTransporte", inversedBy="modalidades") */
    private $modalidadTransporte;

    /**
     * @var string
     *
     * @ORM\Column(name="transporte_pasajeros", type="string", length=255, nullable=true)
     */
    private $transportePasajeros;

    /**
     * @var string
     *
     * @ORM\Column(name="especial_pasajeros", type="string", length=255, nullable=true)
     */
    private $especialPasajeros;

    /****************************************************INFRACTOR*************************************************************/

    /**
     * @var string
     *
     * @ORM\Column(name="infractor_tipo_docmento", type="string", length=255, nullable=true)
     */
    private $infractorTipoDocumento;

    /**
     * @var int
     *
     * @ORM\Column(name="infractor_identificacion", type="bigint", length=20)
     */
    private $infractorIdentificacion;

    /**
     * @var int
     *
     * @ORM\Column(name="infractor_numero_licencia_conduccion", type="bigint", length=30)
     */
    private $infractorNumeroLicenciaConduccion;

    /**
     * @var string
     *
     * @ORM\Column(name="categoria", type="string", length=255, nullable=true)
     */
    private $categoria;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha_expedicion", type="string", length=255, nullable=true)
     */
    private $fechaExpedicion;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha_vencimiento", type="string", length=255, nullable=true)
     */
    private $fechaVencimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="infractor_nombres", type="string", length=255)
     */
    private $infractorNombres;

    /**
     * @var string
     *
     * @ORM\Column(name="infractor_apellidos", type="string", length=255)
     */
    private $infractorApellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="infractor_direccion", type="string", length=255)
     */
    private $infractorDireccion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="infractor_fecha_nacimiento", type="date")
     */
    private $infractorFechaNacimiento;

    /**
     * @var int
     *
     * @ORM\Column(name="infractor_telefono", type="integer", length=255)
     */
    private $infractorTelefono;

    /**
     * @var string
     *
     * @ORM\Column(name="infractor_municipio_residencia", type="string", length=255, nullable=true)
     */
    private $infractorMunicipioResidencia;

    /**
     * @var string
     *
     * @ORM\Column(name="infractor_email", type="string", length=255, nullable=true)
     */
    private $infractorEmail;
    
    /*******************************************************TIPO INFRACTOR******************************************************/
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CfgTipoInfractor", inversedBy="comparendos")
     **/
    protected $tipoInfractor;
    
    /*******************************************************LICENCIA DE TRANSITO******************************************************/
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SedeOperativa", inversedBy="sedesOperativas")
     **/
    protected $organismoTransito;
    
    /**
     * @var string
     *
     * @ORM\Column(name="numero_licencia_transito", type="string", length=255, nullable=true)
     */
    private $numeroLicenciaTransito;
    
    
    /*******************************************************DATOS PROPIETARIO******************************************************/
    
    /**
     * @var string
     *
     * @ORM\Column(name="propietario_tipo_documento", type="string", length=255)
     */
    private $propietarioTipoDocumento;

    /**
     * @var int
     *
     * @ORM\Column(name="propietario_identificacion", type="bigint", length=20)
     */
    private $propietarioIdentificacion;
    
    /**
     * @var string
     *
     * @ORM\Column(name="propietario_nombres", type="string", length=255)
     */
    private $propietarioNombre;
    
    /**
     * @var string
     *
     * @ORM\Column(name="propietario_apellidos", type="string", length=255)
     */
    private $propietarioApellidos;
    
    
    
    /*******************************************************EMPRESA******************************************************/
    
    /**
     * @var string
     *
     * @ORM\Column(name="empresa_nit", type="string", length=255)
     */
    private $empresaNit;
    
    /**
     * @var string
     *
     * @ORM\Column(name="empresa_nombre", type="string", length=255)
     */
    private $empresaNombre;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nit", type="string", length=255)
     */
    private $tarjetaOperacion;
    
    
    /*******************************************************AGENTE TRANSITO******************************************************/
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MpersonalFuncionario", inversedBy="comparendos")
     **/
    protected $agenteTransito;
    
    
    /*******************************************************INMOVILIZACION******************************************************/
    
    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Inmovilizacion")
     */
    private $inmovilizacion;
    
    /*******************************************************OBSERVACIONES******************************************************/
    
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
    
    
    /*******************************************************DATOS TESTIGO******************************************************/
    
    /**
     * @var string
     *
     * @ORM\Column(name="ciudadano_testigo_nombres", type="text", nullable=true)
     */
    private $ciudadanoTestigoNombres;
    
    /**
     * @var string
     *
     * @ORM\Column(name="ciudadano_testigo_apellidos", type="text", nullable=true)
     */
    private $ciudadanoTestigoApellidos;
    
    /**
     * @var string
     *
     * @ORM\Column(name="ciudadano_testigo_identificacion", type="text", nullable=true)
     */
    private $ciudadanoTestigoIdentificacion;
    
    /**
     * @var string
     *
     * @ORM\Column(name="ciudadano_testigo_direccion", type="text", nullable=true)
     */
    private $ciudadanoTestigoDireccion;
    
    /**
     * @var string
     *
     * @ORM\Column(name="ciudadano_testigo_telefono", type="text", nullable=true)
     */
    private $ciudadanoTestigoTelefono;
    
    
    /*******************************************************OTROS DATOS******************************************************/
    
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MpersonalComparendo", inversedBy="comparendos")
     **/
    protected $consecutivo;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ContravencionalBundle\Entity\CvAcuerdoPago", inversedBy="comparendos")
     **/
    protected $acuerdoPago;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CfgComparendoEstado", inversedBy="comparendos")
     **/
    protected $estado;

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
     * Set placa
     *
     * @param string $placa
     *
     * @return Comparendo
     */
    public function setPlaca($placa)
    {
        $this->placa = $placa;

        return $this;
    }

    /**
     * Get placa
     *
     * @return string
     */
    public function getPlaca()
    {
        return $this->placa;
    }

    /**
     * Set codigoInfraccion
     *
     * @param string $codigoInfraccion
     *
     * @return Comparendo
     */
    public function setCodigoInfraccion($codigoInfraccion)
    {
        $this->codigoInfraccion = $codigoInfraccion;

        return $this;
    }

    /**
     * Get codigoInfraccion
     *
     * @return string
     */
    public function getCodigoInfraccion()
    {
        return $this->codigoInfraccion;
    }

    /**
     * Set transportePasajeros
     *
     * @param string $transportePasajeros
     *
     * @return Comparendo
     */
    public function setTransportePasajeros($transportePasajeros)
    {
        $this->transportePasajeros = $transportePasajeros;

        return $this;
    }

    /**
     * Get transportePasajeros
     *
     * @return string
     */
    public function getTransportePasajeros()
    {
        return $this->transportePasajeros;
    }

    /**
     * Set especialPasajeros
     *
     * @param string $especialPasajeros
     *
     * @return Comparendo
     */
    public function setEspecialPasajeros($especialPasajeros)
    {
        $this->especialPasajeros = $especialPasajeros;

        return $this;
    }

    /**
     * Get especialPasajeros
     *
     * @return string
     */
    public function getEspecialPasajeros()
    {
        return $this->especialPasajeros;
    }

    /**
     * Set infractorTipoDocumento
     *
     * @param string $infractorTipoDocumento
     *
     * @return Comparendo
     */
    public function setInfractorTipoDocumento($infractorTipoDocumento)
    {
        $this->infractorTipoDocumento = $infractorTipoDocumento;

        return $this;
    }

    /**
     * Get infractorTipoDocumento
     *
     * @return string
     */
    public function getInfractorTipoDocumento()
    {
        return $this->infractorTipoDocumento;
    }

    /**
     * Set infractorIdentificacion
     *
     * @param integer $infractorIdentificacion
     *
     * @return Comparendo
     */
    public function setInfractorIdentificacion($infractorIdentificacion)
    {
        $this->infractorIdentificacion = $infractorIdentificacion;

        return $this;
    }

    /**
     * Get infractorIdentificacion
     *
     * @return integer
     */
    public function getInfractorIdentificacion()
    {
        return $this->infractorIdentificacion;
    }

    /**
     * Set infractorNumeroLicenciaConduccion
     *
     * @param integer $infractorNumeroLicenciaConduccion
     *
     * @return Comparendo
     */
    public function setInfractorNumeroLicenciaConduccion($infractorNumeroLicenciaConduccion)
    {
        $this->infractorNumeroLicenciaConduccion = $infractorNumeroLicenciaConduccion;

        return $this;
    }

    /**
     * Get infractorNumeroLicenciaConduccion
     *
     * @return integer
     */
    public function getInfractorNumeroLicenciaConduccion()
    {
        return $this->infractorNumeroLicenciaConduccion;
    }

    /**
     * Set categoria
     *
     * @param string $categoria
     *
     * @return Comparendo
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return string
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set fechaExpedicion
     *
     * @param string $fechaExpedicion
     *
     * @return Comparendo
     */
    public function setFechaExpedicion($fechaExpedicion)
    {
        $this->fechaExpedicion = $fechaExpedicion;

        return $this;
    }

    /**
     * Get fechaExpedicion
     *
     * @return string
     */
    public function getFechaExpedicion()
    {
        if ($this->fechaExpedicion) {
            return $this->fechaExpedicion->format('d/m/Y');
        }
        return $this->fechaExpedicion;

    }

    /**
     * Set fechaVencimiento
     *
     * @param string $fechaVencimiento
     *
     * @return Comparendo
     */
    public function setFechaVencimiento($fechaVencimiento)
    {
        $this->fechaVencimiento = $fechaVencimiento;

        return $this;
    }

    /**
     * Get fechaVencimiento
     *
     * @return string
     */
    public function getFechaVencimiento()
    {
        if ($this->fechaVencimiento) {
            return $this->fechaVencimiento->format('d/m/Y');
        }
        return $this->fechaVencimiento;

    }

    /**
     * Set infractorNombres
     *
     * @param string $infractorNombres
     *
     * @return Comparendo
     */
    public function setInfractorNombres($infractorNombres)
    {
        $this->infractorNombres = $infractorNombres;

        return $this;
    }

    /**
     * Get infractorNombres
     *
     * @return string
     */
    public function getInfractorNombres()
    {
        return $this->infractorNombres;
    }

    /**
     * Set infractorApellidos
     *
     * @param string $infractorApellidos
     *
     * @return Comparendo
     */
    public function setInfractorApellidos($infractorApellidos)
    {
        $this->infractorApellidos = $infractorApellidos;

        return $this;
    }

    /**
     * Get infractorApellidos
     *
     * @return string
     */
    public function getInfractorApellidos()
    {
        return $this->infractorApellidos;
    }

    /**
     * Set infractorDireccion
     *
     * @param string $infractorDireccion
     *
     * @return Comparendo
     */
    public function setInfractorDireccion($infractorDireccion)
    {
        $this->infractorDireccion = $infractorDireccion;

        return $this;
    }

    /**
     * Get infractorDireccion
     *
     * @return string
     */
    public function getInfractorDireccion()
    {
        return $this->infractorDireccion;
    }

    /**
     * Set infractorFechaNacimiento
     *
     * @param \DateTime $infractorFechaNacimiento
     *
     * @return Comparendo
     */
    public function setInfractorFechaNacimiento($infractorFechaNacimiento)
    {
        $this->infractorFechaNacimiento = $infractorFechaNacimiento;

        return $this;
    }

    /**
     * Get infractorFechaNacimiento
     *
     * @return \DateTime
     */
    public function getInfractorFechaNacimiento()
    {
        if ($this->infractorFechaNacimiento) {
            return $this->infractorFechaNacimiento->format('d/m/Y');
        }
        return $this->infractorFechaNacimiento;

    }

    /**
     * Set infractorTelefono
     *
     * @param integer $infractorTelefono
     *
     * @return Comparendo
     */
    public function setInfractorTelefono($infractorTelefono)
    {
        $this->infractorTelefono = $infractorTelefono;

        return $this;
    }

    /**
     * Get infractorTelefono
     *
     * @return integer
     */
    public function getInfractorTelefono()
    {
        return $this->infractorTelefono;
    }

    /**
     * Set infractorMunicipioResidencia
     *
     * @param string $infractorMunicipioResidencia
     *
     * @return Comparendo
     */
    public function setInfractorMunicipioResidencia($infractorMunicipioResidencia)
    {
        $this->infractorMunicipioResidencia = $infractorMunicipioResidencia;

        return $this;
    }

    /**
     * Get infractorMunicipioResidencia
     *
     * @return string
     */
    public function getInfractorMunicipioResidencia()
    {
        return $this->infractorMunicipioResidencia;
    }

    /**
     * Set infractorEmail
     *
     * @param string $infractorEmail
     *
     * @return Comparendo
     */
    public function setInfractorEmail($infractorEmail)
    {
        $this->infractorEmail = $infractorEmail;

        return $this;
    }

    /**
     * Get infractorEmail
     *
     * @return string
     */
    public function getInfractorEmail()
    {
        return $this->infractorEmail;
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
     * Set propietarioTipoDocumento
     *
     * @param string $propietarioTipoDocumento
     *
     * @return Comparendo
     */
    public function setPropietarioTipoDocumento($propietarioTipoDocumento)
    {
        $this->propietarioTipoDocumento = $propietarioTipoDocumento;

        return $this;
    }

    /**
     * Get propietarioTipoDocumento
     *
     * @return string
     */
    public function getPropietarioTipoDocumento()
    {
        return $this->propietarioTipoDocumento;
    }

    /**
     * Set propietarioIdentificacion
     *
     * @param integer $propietarioIdentificacion
     *
     * @return Comparendo
     */
    public function setPropietarioIdentificacion($propietarioIdentificacion)
    {
        $this->propietarioIdentificacion = $propietarioIdentificacion;

        return $this;
    }

    /**
     * Get propietarioIdentificacion
     *
     * @return integer
     */
    public function getPropietarioIdentificacion()
    {
        return $this->propietarioIdentificacion;
    }

    /**
     * Set propietarioNombre
     *
     * @param string $propietarioNombre
     *
     * @return Comparendo
     */
    public function setPropietarioNombre($propietarioNombre)
    {
        $this->propietarioNombre = $propietarioNombre;

        return $this;
    }

    /**
     * Get propietarioNombre
     *
     * @return string
     */
    public function getPropietarioNombre()
    {
        return $this->propietarioNombre;
    }

    /**
     * Set propietarioApellidos
     *
     * @param string $propietarioApellidos
     *
     * @return Comparendo
     */
    public function setPropietarioApellidos($propietarioApellidos)
    {
        $this->propietarioApellidos = $propietarioApellidos;

        return $this;
    }

    /**
     * Get propietarioApellidos
     *
     * @return string
     */
    public function getPropietarioApellidos()
    {
        return $this->propietarioApellidos;
    }

    /**
     * Set empresaNit
     *
     * @param string $empresaNit
     *
     * @return Comparendo
     */
    public function setEmpresaNit($empresaNit)
    {
        $this->empresaNit = $empresaNit;

        return $this;
    }

    /**
     * Get empresaNit
     *
     * @return string
     */
    public function getEmpresaNit()
    {
        return $this->empresaNit;
    }

    /**
     * Set empresaNombre
     *
     * @param string $empresaNombre
     *
     * @return Comparendo
     */
    public function setEmpresaNombre($empresaNombre)
    {
        $this->empresaNombre = $empresaNombre;

        return $this;
    }

    /**
     * Get empresaNombre
     *
     * @return string
     */
    public function getEmpresaNombre()
    {
        return $this->empresaNombre;
    }

    /**
     * Set tarjetaOperacion
     *
     * @param string $tarjetaOperacion
     *
     * @return Comparendo
     */
    public function setTarjetaOperacion($tarjetaOperacion)
    {
        $this->tarjetaOperacion = $tarjetaOperacion;

        return $this;
    }

    /**
     * Get tarjetaOperacion
     *
     * @return string
     */
    public function getTarjetaOperacion()
    {
        return $this->tarjetaOperacion;
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
     * Set ciudadanoTestigoNombres
     *
     * @param string $ciudadanoTestigoNombres
     *
     * @return Comparendo
     */
    public function setCiudadanoTestigoNombres($ciudadanoTestigoNombres)
    {
        $this->ciudadanoTestigoNombres = $ciudadanoTestigoNombres;

        return $this;
    }

    /**
     * Get ciudadanoTestigoNombres
     *
     * @return string
     */
    public function getCiudadanoTestigoNombres()
    {
        return $this->ciudadanoTestigoNombres;
    }

    /**
     * Set ciudadanoTestigoApellidos
     *
     * @param string $ciudadanoTestigoApellidos
     *
     * @return Comparendo
     */
    public function setCiudadanoTestigoApellidos($ciudadanoTestigoApellidos)
    {
        $this->ciudadanoTestigoApellidos = $ciudadanoTestigoApellidos;

        return $this;
    }

    /**
     * Get ciudadanoTestigoApellidos
     *
     * @return string
     */
    public function getCiudadanoTestigoApellidos()
    {
        return $this->ciudadanoTestigoApellidos;
    }

    /**
     * Set ciudadanoTestigoIdentificacion
     *
     * @param string $ciudadanoTestigoIdentificacion
     *
     * @return Comparendo
     */
    public function setCiudadanoTestigoIdentificacion($ciudadanoTestigoIdentificacion)
    {
        $this->ciudadanoTestigoIdentificacion = $ciudadanoTestigoIdentificacion;

        return $this;
    }

    /**
     * Get ciudadanoTestigoIdentificacion
     *
     * @return string
     */
    public function getCiudadanoTestigoIdentificacion()
    {
        return $this->ciudadanoTestigoIdentificacion;
    }

    /**
     * Set ciudadanoTestigoDireccion
     *
     * @param string $ciudadanoTestigoDireccion
     *
     * @return Comparendo
     */
    public function setCiudadanoTestigoDireccion($ciudadanoTestigoDireccion)
    {
        $this->ciudadanoTestigoDireccion = $ciudadanoTestigoDireccion;

        return $this;
    }

    /**
     * Get ciudadanoTestigoDireccion
     *
     * @return string
     */
    public function getCiudadanoTestigoDireccion()
    {
        return $this->ciudadanoTestigoDireccion;
    }

    /**
     * Set ciudadanoTestigoTelefono
     *
     * @param string $ciudadanoTestigoTelefono
     *
     * @return Comparendo
     */
    public function setCiudadanoTestigoTelefono($ciudadanoTestigoTelefono)
    {
        $this->ciudadanoTestigoTelefono = $ciudadanoTestigoTelefono;

        return $this;
    }

    /**
     * Get ciudadanoTestigoTelefono
     *
     * @return string
     */
    public function getCiudadanoTestigoTelefono()
    {
        return $this->ciudadanoTestigoTelefono;
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
     * Set matriculadoEn
     *
     * @param \AppBundle\Entity\Municipio $matriculadoEn
     *
     * @return Comparendo
     */
    public function setMatriculadoEn(\AppBundle\Entity\Municipio $matriculadoEn = null)
    {
        $this->matriculadoEn = $matriculadoEn;

        return $this;
    }

    /**
     * Get matriculadoEn
     *
     * @return \AppBundle\Entity\Municipio
     */
    public function getMatriculadoEn()
    {
        return $this->matriculadoEn;
    }

    /**
     * Set clase
     *
     * @param \AppBundle\Entity\Clase $clase
     *
     * @return Comparendo
     */
    public function setClase(\AppBundle\Entity\Clase $clase = null)
    {
        $this->clase = $clase;

        return $this;
    }

    /**
     * Get clase
     *
     * @return \AppBundle\Entity\Clase
     */
    public function getClase()
    {
        return $this->clase;
    }

    /**
     * Set servicio
     *
     * @param \AppBundle\Entity\Servicio $servicio
     *
     * @return Comparendo
     */
    public function setServicio(\AppBundle\Entity\Servicio $servicio = null)
    {
        $this->servicio = $servicio;

        return $this;
    }

    /**
     * Get servicio
     *
     * @return \AppBundle\Entity\Servicio
     */
    public function getServicio()
    {
        return $this->servicio;
    }

    /**
     * Set radioAccion
     *
     * @param \AppBundle\Entity\CfgRadioAccion $radioAccion
     *
     * @return Comparendo
     */
    public function setRadioAccion(\AppBundle\Entity\CfgRadioAccion $radioAccion = null)
    {
        $this->radioAccion = $radioAccion;

        return $this;
    }

    /**
     * Get radioAccion
     *
     * @return \AppBundle\Entity\CfgRadioAccion
     */
    public function getRadioAccion()
    {
        return $this->radioAccion;
    }

    /**
     * Set modalidadTransporte
     *
     * @param \AppBundle\Entity\CfgModalidadTransporte $modalidadTransporte
     *
     * @return Comparendo
     */
    public function setModalidadTransporte(\AppBundle\Entity\CfgModalidadTransporte $modalidadTransporte = null)
    {
        $this->modalidadTransporte = $modalidadTransporte;

        return $this;
    }

    /**
     * Get modalidadTransporte
     *
     * @return \AppBundle\Entity\CfgModalidadTransporte
     */
    public function getModalidadTransporte()
    {
        return $this->modalidadTransporte;
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
     * Set organismoTransito
     *
     * @param \AppBundle\Entity\SedeOperativa $organismoTransito
     *
     * @return Comparendo
     */
    public function setOrganismoTransito(\AppBundle\Entity\SedeOperativa $organismoTransito = null)
    {
        $this->organismoTransito = $organismoTransito;

        return $this;
    }

    /**
     * Get organismoTransito
     *
     * @return \AppBundle\Entity\SedeOperativa
     */
    public function getOrganismoTransito()
    {
        return $this->organismoTransito;
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
     * Set inmovilizacion
     *
     * @param \AppBundle\Entity\Inmovilizacion $inmovilizacion
     *
     * @return Comparendo
     */
    public function setInmovilizacion(\AppBundle\Entity\Inmovilizacion $inmovilizacion = null)
    {
        $this->inmovilizacion = $inmovilizacion;

        return $this;
    }

    /**
     * Get inmovilizacion
     *
     * @return \AppBundle\Entity\Inmovilizacion
     */
    public function getInmovilizacion()
    {
        return $this->inmovilizacion;
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
}
