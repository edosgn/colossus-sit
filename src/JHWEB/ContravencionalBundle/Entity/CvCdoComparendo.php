<?php

namespace JHWEB\ContravencionalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CvCdoComparendo
 *
 * @ORM\Table(name="cv_cdo_comparendo")
 * @ORM\Entity(repositoryClass="JHWEB\ContravencionalBundle\Repository\CvCdoComparendoRepository")
 */
class CvCdoComparendo
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
     * @ORM\Column(name="expediente_numero", type="string", length=255, nullable=true)
     */
    private $expedienteNumero;

    /**
     * @var int
     *
     * @ORM\Column(name="expediente_consecutivo", type="integer", nullable=true)
     */
    private $expedienteConsecutivo;

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
     * @ORM\Column(name="placa", type="string", length=255, nullable=true)
     */
    private $placa;

    /*************************DATOS INFRACTOR***************************/

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserCfgTipoIdentificacion", inversedBy="comparendos")
     **/
    protected $infractorTipoIdentificacion;

    /**
     * @var int
     *
     * @ORM\Column(name="infractor_identificacion", type="bigint", length=20, nullable=true)
     */
    private $infractorIdentificacion;

    /**
     * @var int
     *
     * @ORM\Column(name="infractor_numero_licencia_conduccion", type="bigint", length=30, nullable=true)
     */
    private $infractorNumeroLicenciaConduccion;
  
    /**
     * @var string
     *
     * @ORM\Column(name="categoria", type="string", length=255, nullable=true)
     */
    private $categoria;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_expedicion", type="date", length=255, nullable=true)
     */
    private $fechaExpedicion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_vencimiento", type="date", length=255, nullable=true)
     */
    private $fechaVencimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="infractor_nombres", type="string", length=255, nullable=true)
     */
    private $infractorNombres;

    /**
     * @var string
     *
     * @ORM\Column(name="infractor_apellidos", type="string", length=255, nullable=true)
     */
    private $infractorApellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="infractor_direccion", type="string", length=255, nullable=true)
     */
    private $infractorDireccion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="infractor_fecha_nacimiento", type="date", nullable=true)
     */
    private $infractorFechaNacimiento;

    /**
     * @var int
     *
     * @ORM\Column(name="infractor_edad", type="integer", length=2, nullable=true)
     */
    private $infractorEdad;

    /**
     * @var int
     *
     * @ORM\Column(name="infractor_telefono", type="integer", length=255, nullable=true)
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

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgOrganismoTransito", inversedBy="comparendos")
     **/
    protected $organismoTransitoLicencia;
    
    /**
     * @var string
     *
     * @ORM\Column(name="numero_licencia_transito", type="string", length=255, nullable=true)
     */
    private $numeroLicenciaTransito;

    /**************************DATOS PROPIETARIO************************/

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserCfgTipoIdentificacion", inversedBy="comparendos")
     **/
    protected $propietarioTipoIdentificacion;

    /**
     * @var int
     *
     * @ORM\Column(name="propietario_identificacion", type="bigint", length=20, nullable=true)
     */
    private $propietarioIdentificacion;
    
    /**
     * @var string
     *
     * @ORM\Column(name="propietario_nombres", type="string", length=255, nullable=true)
     */
    private $propietarioNombre;
    
    /**
     * @var string
     *
     * @ORM\Column(name="propietario_apellidos", type="string", length=255, nullable=true)
     */
    private $propietarioApellidos;
    
    /**
     * @var string
     *
     * @ORM\Column(name="empresa_nit", type="string", length=255, nullable=true)
     */
    private $empresaNit;
    
    /**
     * @var string
     *
     * @ORM\Column(name="empresa_nombre", type="string", length=255, nullable=true)
     */
    private $empresaNombre;
    
    /**
     * @var string
     *
     * @ORM\Column(name="tarjeta_operacion", type="string", length=255, nullable=true)
     */
    private $tarjetaOperacion;

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
     * @var string
     *
     * @ORM\Column(name="ciudadano_testigo_nombres", type="string", nullable=true)
     */
    private $testigoNombres;
    
    /**
     * @var string
     *
     * @ORM\Column(name="ciudadano_testigo_apellidos", type="string", nullable=true)
     */
    private $testigoApellidos;
    
    /**
     * @var string
     *
     * @ORM\Column(name="ciudadano_testigo_identificacion", type="string", nullable=true)
     */
    private $testigoIdentificacion;
    
    /**
     * @var string
     *
     * @ORM\Column(name="ciudadano_testigo_direccion", type="string", nullable=true)
     */
    private $testigoDireccion;
    
    /**
     * @var string
     *
     * @ORM\Column(name="ciudadano_testigo_telefono", type="string", nullable=true)
     */
    private $testigoTelefono;

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
     * @var int
     *
     * @ORM\Column(name="valor_infraccion", type="integer", nullable=true)
     */
    private $valorInfraccion;

    /**
     * @var int
     *
     * @ORM\Column(name="interes_mora", type="integer", nullable=true)
     */
    private $interesMora;

    /**
     * @var int
     *
     * @ORM\Column(name="valor_pagar", type="integer", nullable=true)
     */
    private $valorPagar;

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
    private $polca;

    /**
     * @var boolean
     *
     * @ORM\Column(name="audiencia", type="boolean")
     */
    private $audiencia;

    /**
     * @var boolean
     *
     * @ORM\Column(name="recurso", type="boolean")
     */
    private $recurso;

    /**
     * @var boolean
     *
     * @ORM\Column(name="notificado", type="boolean")
     */
    private $notificado;

    /**
     * @var boolean
     *
     * @ORM\Column(name="pagado", type="boolean")
     */
    private $pagado;

    /**
     * @var boolean
     *
     * @ORM\Column(name="curso", type="boolean")
     */
    private $curso;

    /**
     * @var int
     *
     * @ORM\Column(name="porcentaje_descuento", type="integer")
     */
    private $porcentajeDescuento;

    /**
     * @var int
     *
     * @ORM\Column(name="grado_alcoholemia", type="integer", nullable=true)
     */
    private $gradoAlcoholemia;

    /**
     * @var int
     *
     * @ORM\Column(name="reincidencia", type="integer", nullable=true)
     */
    private $reincidencia;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;
    
    /****************************Llaves foraneas****************************/

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgMunicipio", inversedBy="comparendos")
     **/
    protected $municipio;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\FinancieroBundle\Entity\FroInfraccion", inversedBy="comparendos")
     **/
    protected $infraccion;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgOrganismoTransito", inversedBy="comparendos")
     **/
    protected $organismoTransitoMatriculado;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloCfgServicio", inversedBy="comparendos")
     **/
    protected $servicio;
    
    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloCfgClase", inversedBy="comparendos")
     **/
    protected $clase;
    
    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloCfgRadioAccion", inversedBy="comparendos")
     **/
    private $radioAccion;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloCfgModalidadTransporte", inversedBy="comparendos")
     **/   
    private $modalidadTransporte;
    
    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloCfgTransportePasajero", inversedBy="comparendos")
     **/
    private $transportePasajero;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloCfgTransporteEspecial", inversedBy="comparendos")
     **/
    private $transporteEspecial;

    /**
     * @ORM\ManyToOne(targetEntity="CvCdoCfgTipoInfractor", inversedBy="comparendos")
     **/
    protected $tipoInfractor;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgOrganismoTransito", inversedBy="comparendos")
     **/
    protected $organismoTransito;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\PersonalBundle\Entity\PnalFuncionario", inversedBy="comparendos")
     **/
    protected $agenteTransito;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\PersonalBundle\Entity\PnalCfgCdoConsecutivo", inversedBy="comparendos")
     **/
    protected $consecutivo;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\FinancieroBundle\Entity\FroAcuerdoPago", inversedBy="comparendos")
     **/
    protected $acuerdoPago;

    /**
     * @ORM\ManyToOne(targetEntity="CvCdoCfgEstado", inversedBy="comparendos")
     **/
    protected $estado;

    /**
     * @ORM\OneToOne(targetEntity="CvInventarioDocumental")
     * @ORM\JoinColumn(name="inventario_documental_id", referencedColumnName="id")
     */
    private $inventarioDocumental;

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
     * @return CvCdoComparendo
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
     * @return CvCdoComparendo
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
     * Set expedienteNumero
     *
     * @param string $expedienteNumero
     *
     * @return CvCdoComparendo
     */
    public function setExpedienteNumero($expedienteNumero)
    {
        $this->expedienteNumero = $expedienteNumero;

        return $this;
    }

    /**
     * Get expedienteNumero
     *
     * @return string
     */
    public function getExpedienteNumero()
    {
        return $this->expedienteNumero;
    }

    /**
     * Set expedienteConsecutivo
     *
     * @param integer $expedienteConsecutivo
     *
     * @return CvCdoComparendo
     */
    public function setExpedienteConsecutivo($expedienteConsecutivo)
    {
        $this->expedienteConsecutivo = $expedienteConsecutivo;

        return $this;
    }

    /**
     * Get expedienteConsecutivo
     *
     * @return integer
     */
    public function getExpedienteConsecutivo()
    {
        return $this->expedienteConsecutivo;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return CvCdoComparendo
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
     * @return CvCdoComparendo
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
     * @return CvCdoComparendo
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
     * Set infractorIdentificacion
     *
     * @param integer $infractorIdentificacion
     *
     * @return CvCdoComparendo
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
     * @return CvCdoComparendo
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
     * @return CvCdoComparendo
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
     * @param \DateTime $fechaExpedicion
     *
     * @return CvCdoComparendo
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
     * Set fechaVencimiento
     *
     * @param \DateTime $fechaVencimiento
     *
     * @return CvCdoComparendo
     */
    public function setFechaVencimiento($fechaVencimiento)
    {
        $this->fechaVencimiento = $fechaVencimiento;

        return $this;
    }

    /**
     * Get fechaVencimiento
     *
     * @return \DateTime
     */
    public function getFechaVencimiento()
    {
        return $this->fechaVencimiento;
    }

    /**
     * Set infractorNombres
     *
     * @param string $infractorNombres
     *
     * @return CvCdoComparendo
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
     * @return CvCdoComparendo
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
     * @return CvCdoComparendo
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
     * @return CvCdoComparendo
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
        return $this->infractorFechaNacimiento;
    }

    /**
     * Set infractorEdad
     *
     * @param integer $infractorEdad
     *
     * @return CvCdoComparendo
     */
    public function setInfractorEdad($infractorEdad)
    {
        $this->infractorEdad = $infractorEdad;

        return $this;
    }

    /**
     * Get infractorEdad
     *
     * @return integer
     */
    public function getInfractorEdad()
    {
        return $this->infractorEdad;
    }

    /**
     * Set infractorTelefono
     *
     * @param integer $infractorTelefono
     *
     * @return CvCdoComparendo
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
     * @return CvCdoComparendo
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
     * @return CvCdoComparendo
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
     * @return CvCdoComparendo
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
     * Set propietarioIdentificacion
     *
     * @param integer $propietarioIdentificacion
     *
     * @return CvCdoComparendo
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
     * @return CvCdoComparendo
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
     * @return CvCdoComparendo
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
     * @return CvCdoComparendo
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
     * @return CvCdoComparendo
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
     * @return CvCdoComparendo
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
     * @return CvCdoComparendo
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
     * @return CvCdoComparendo
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
     * Set testigoNombres
     *
     * @param string $testigoNombres
     *
     * @return CvCdoComparendo
     */
    public function setTestigoNombres($testigoNombres)
    {
        $this->testigoNombres = $testigoNombres;

        return $this;
    }

    /**
     * Get testigoNombres
     *
     * @return string
     */
    public function getTestigoNombres()
    {
        return $this->testigoNombres;
    }

    /**
     * Set testigoApellidos
     *
     * @param string $testigoApellidos
     *
     * @return CvCdoComparendo
     */
    public function setTestigoApellidos($testigoApellidos)
    {
        $this->testigoApellidos = $testigoApellidos;

        return $this;
    }

    /**
     * Get testigoApellidos
     *
     * @return string
     */
    public function getTestigoApellidos()
    {
        return $this->testigoApellidos;
    }

    /**
     * Set testigoIdentificacion
     *
     * @param string $testigoIdentificacion
     *
     * @return CvCdoComparendo
     */
    public function setTestigoIdentificacion($testigoIdentificacion)
    {
        $this->testigoIdentificacion = $testigoIdentificacion;

        return $this;
    }

    /**
     * Get testigoIdentificacion
     *
     * @return string
     */
    public function getTestigoIdentificacion()
    {
        return $this->testigoIdentificacion;
    }

    /**
     * Set testigoDireccion
     *
     * @param string $testigoDireccion
     *
     * @return CvCdoComparendo
     */
    public function setTestigoDireccion($testigoDireccion)
    {
        $this->testigoDireccion = $testigoDireccion;

        return $this;
    }

    /**
     * Get testigoDireccion
     *
     * @return string
     */
    public function getTestigoDireccion()
    {
        return $this->testigoDireccion;
    }

    /**
     * Set testigoTelefono
     *
     * @param string $testigoTelefono
     *
     * @return CvCdoComparendo
     */
    public function setTestigoTelefono($testigoTelefono)
    {
        $this->testigoTelefono = $testigoTelefono;

        return $this;
    }

    /**
     * Get testigoTelefono
     *
     * @return string
     */
    public function getTestigoTelefono()
    {
        return $this->testigoTelefono;
    }

    /**
     * Set fuga
     *
     * @param boolean $fuga
     *
     * @return CvCdoComparendo
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
     * @return CvCdoComparendo
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
     * @return CvCdoComparendo
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
     * Set valorInfraccion
     *
     * @param integer $valorInfraccion
     *
     * @return CvCdoComparendo
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
     * Set interesMora
     *
     * @param integer $interesMora
     *
     * @return CvCdoComparendo
     */
    public function setInteresMora($interesMora)
    {
        $this->interesMora = $interesMora;

        return $this;
    }

    /**
     * Get interesMora
     *
     * @return integer
     */
    public function getInteresMora()
    {
        return $this->interesMora;
    }

    /**
     * Set valorPagar
     *
     * @param integer $valorPagar
     *
     * @return CvCdoComparendo
     */
    public function setValorPagar($valorPagar)
    {
        $this->valorPagar = $valorPagar;

        return $this;
    }

    /**
     * Get valorPagar
     *
     * @return integer
     */
    public function getValorPagar()
    {
        return $this->valorPagar;
    }

    /**
     * Set valorAdicional
     *
     * @param integer $valorAdicional
     *
     * @return CvCdoComparendo
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
     * @return CvCdoComparendo
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
     * @return CvCdoComparendo
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
     * Set audiencia
     *
     * @param boolean $audiencia
     *
     * @return CvCdoComparendo
     */
    public function setAudiencia($audiencia)
    {
        $this->audiencia = $audiencia;

        return $this;
    }

    /**
     * Get audiencia
     *
     * @return boolean
     */
    public function getAudiencia()
    {
        return $this->audiencia;
    }

    /**
     * Set recurso
     *
     * @param boolean $recurso
     *
     * @return CvCdoComparendo
     */
    public function setRecurso($recurso)
    {
        $this->recurso = $recurso;

        return $this;
    }

    /**
     * Get recurso
     *
     * @return boolean
     */
    public function getRecurso()
    {
        return $this->recurso;
    }

    /**
     * Set notificado
     *
     * @param boolean $notificado
     *
     * @return CvCdoComparendo
     */
    public function setNotificado($notificado)
    {
        $this->notificado = $notificado;

        return $this;
    }

    /**
     * Get notificado
     *
     * @return boolean
     */
    public function getNotificado()
    {
        return $this->notificado;
    }

    /**
     * Set pagado
     *
     * @param boolean $pagado
     *
     * @return CvCdoComparendo
     */
    public function setPagado($pagado)
    {
        $this->pagado = $pagado;

        return $this;
    }

    /**
     * Get pagado
     *
     * @return boolean
     */
    public function getPagado()
    {
        return $this->pagado;
    }

    /**
     * Set curso
     *
     * @param boolean $curso
     *
     * @return CvCdoComparendo
     */
    public function setCurso($curso)
    {
        $this->curso = $curso;

        return $this;
    }

    /**
     * Get curso
     *
     * @return boolean
     */
    public function getCurso()
    {
        return $this->curso;
    }

    /**
     * Set porcentajeDescuento
     *
     * @param integer $porcentajeDescuento
     *
     * @return CvCdoComparendo
     */
    public function setPorcentajeDescuento($porcentajeDescuento)
    {
        $this->porcentajeDescuento = $porcentajeDescuento;

        return $this;
    }

    /**
     * Get porcentajeDescuento
     *
     * @return integer
     */
    public function getPorcentajeDescuento()
    {
        return $this->porcentajeDescuento;
    }

    /**
     * Set gradoAlcoholemia
     *
     * @param integer $gradoAlcoholemia
     *
     * @return CvCdoComparendo
     */
    public function setGradoAlcoholemia($gradoAlcoholemia)
    {
        $this->gradoAlcoholemia = $gradoAlcoholemia;

        return $this;
    }

    /**
     * Get gradoAlcoholemia
     *
     * @return integer
     */
    public function getGradoAlcoholemia()
    {
        return $this->gradoAlcoholemia;
    }

    /**
     * Set reincidencia
     *
     * @param integer $reincidencia
     *
     * @return CvCdoComparendo
     */
    public function setReincidencia($reincidencia)
    {
        $this->reincidencia = $reincidencia;

        return $this;
    }

    /**
     * Get reincidencia
     *
     * @return integer
     */
    public function getReincidencia()
    {
        return $this->reincidencia;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CvCdoComparendo
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
     * Set infractorTipoIdentificacion
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserCfgTipoIdentificacion $infractorTipoIdentificacion
     *
     * @return CvCdoComparendo
     */
    public function setInfractorTipoIdentificacion(\JHWEB\UsuarioBundle\Entity\UserCfgTipoIdentificacion $infractorTipoIdentificacion = null)
    {
        $this->infractorTipoIdentificacion = $infractorTipoIdentificacion;

        return $this;
    }

    /**
     * Get infractorTipoIdentificacion
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserCfgTipoIdentificacion
     */
    public function getInfractorTipoIdentificacion()
    {
        return $this->infractorTipoIdentificacion;
    }

    /**
     * Set organismoTransitoLicencia
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgOrganismoTransito $organismoTransitoLicencia
     *
     * @return CvCdoComparendo
     */
    public function setOrganismoTransitoLicencia(\JHWEB\ConfigBundle\Entity\CfgOrganismoTransito $organismoTransitoLicencia = null)
    {
        $this->organismoTransitoLicencia = $organismoTransitoLicencia;

        return $this;
    }

    /**
     * Get organismoTransitoLicencia
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgOrganismoTransito
     */
    public function getOrganismoTransitoLicencia()
    {
        return $this->organismoTransitoLicencia;
    }

    /**
     * Set propietarioTipoIdentificacion
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserCfgTipoIdentificacion $propietarioTipoIdentificacion
     *
     * @return CvCdoComparendo
     */
    public function setPropietarioTipoIdentificacion(\JHWEB\UsuarioBundle\Entity\UserCfgTipoIdentificacion $propietarioTipoIdentificacion = null)
    {
        $this->propietarioTipoIdentificacion = $propietarioTipoIdentificacion;

        return $this;
    }

    /**
     * Get propietarioTipoIdentificacion
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserCfgTipoIdentificacion
     */
    public function getPropietarioTipoIdentificacion()
    {
        return $this->propietarioTipoIdentificacion;
    }

    /**
     * Set municipio
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgMunicipio $municipio
     *
     * @return CvCdoComparendo
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
     * Set infraccion
     *
     * @param \JHWEB\FinancieroBundle\Entity\FroInfraccion $infraccion
     *
     * @return CvCdoComparendo
     */
    public function setInfraccion(\JHWEB\FinancieroBundle\Entity\FroInfraccion $infraccion = null)
    {
        $this->infraccion = $infraccion;

        return $this;
    }

    /**
     * Get infraccion
     *
     * @return \JHWEB\FinancieroBundle\Entity\FroInfraccion
     */
    public function getInfraccion()
    {
        return $this->infraccion;
    }

    /**
     * Set organismoTransitoMatriculado
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgOrganismoTransito $organismoTransitoMatriculado
     *
     * @return CvCdoComparendo
     */
    public function setOrganismoTransitoMatriculado(\JHWEB\ConfigBundle\Entity\CfgOrganismoTransito $organismoTransitoMatriculado = null)
    {
        $this->organismoTransitoMatriculado = $organismoTransitoMatriculado;

        return $this;
    }

    /**
     * Get organismoTransitoMatriculado
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgOrganismoTransito
     */
    public function getOrganismoTransitoMatriculado()
    {
        return $this->organismoTransitoMatriculado;
    }

    /**
     * Set servicio
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgServicio $servicio
     *
     * @return CvCdoComparendo
     */
    public function setServicio(\JHWEB\VehiculoBundle\Entity\VhloCfgServicio $servicio = null)
    {
        $this->servicio = $servicio;

        return $this;
    }

    /**
     * Get servicio
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgServicio
     */
    public function getServicio()
    {
        return $this->servicio;
    }

    /**
     * Set clase
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgClase $clase
     *
     * @return CvCdoComparendo
     */
    public function setClase(\JHWEB\VehiculoBundle\Entity\VhloCfgClase $clase = null)
    {
        $this->clase = $clase;

        return $this;
    }

    /**
     * Get clase
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgClase
     */
    public function getClase()
    {
        return $this->clase;
    }

    /**
     * Set radioAccion
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgRadioAccion $radioAccion
     *
     * @return CvCdoComparendo
     */
    public function setRadioAccion(\JHWEB\VehiculoBundle\Entity\VhloCfgRadioAccion $radioAccion = null)
    {
        $this->radioAccion = $radioAccion;

        return $this;
    }

    /**
     * Get radioAccion
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgRadioAccion
     */
    public function getRadioAccion()
    {
        return $this->radioAccion;
    }

    /**
     * Set modalidadTransporte
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgModalidadTransporte $modalidadTransporte
     *
     * @return CvCdoComparendo
     */
    public function setModalidadTransporte(\JHWEB\VehiculoBundle\Entity\VhloCfgModalidadTransporte $modalidadTransporte = null)
    {
        $this->modalidadTransporte = $modalidadTransporte;

        return $this;
    }

    /**
     * Get modalidadTransporte
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgModalidadTransporte
     */
    public function getModalidadTransporte()
    {
        return $this->modalidadTransporte;
    }

    /**
     * Set transportePasajero
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgTransportePasajero $transportePasajero
     *
     * @return CvCdoComparendo
     */
    public function setTransportePasajero(\JHWEB\VehiculoBundle\Entity\VhloCfgTransportePasajero $transportePasajero = null)
    {
        $this->transportePasajero = $transportePasajero;

        return $this;
    }

    /**
     * Get transportePasajero
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgTransportePasajero
     */
    public function getTransportePasajero()
    {
        return $this->transportePasajero;
    }

    /**
     * Set transporteEspecial
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgTransporteEspecial $transporteEspecial
     *
     * @return CvCdoComparendo
     */
    public function setTransporteEspecial(\JHWEB\VehiculoBundle\Entity\VhloCfgTransporteEspecial $transporteEspecial = null)
    {
        $this->transporteEspecial = $transporteEspecial;

        return $this;
    }

    /**
     * Get transporteEspecial
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgTransporteEspecial
     */
    public function getTransporteEspecial()
    {
        return $this->transporteEspecial;
    }

    /**
     * Set tipoInfractor
     *
     * @param \JHWEB\ContravencionalBundle\Entity\CvCdoCfgTipoInfractor $tipoInfractor
     *
     * @return CvCdoComparendo
     */
    public function setTipoInfractor(\JHWEB\ContravencionalBundle\Entity\CvCdoCfgTipoInfractor $tipoInfractor = null)
    {
        $this->tipoInfractor = $tipoInfractor;

        return $this;
    }

    /**
     * Get tipoInfractor
     *
     * @return \JHWEB\ContravencionalBundle\Entity\CvCdoCfgTipoInfractor
     */
    public function getTipoInfractor()
    {
        return $this->tipoInfractor;
    }

    /**
     * Set organismoTransito
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgOrganismoTransito $organismoTransito
     *
     * @return CvCdoComparendo
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
     * Set agenteTransito
     *
     * @param \JHWEB\PersonalBundle\Entity\PnalFuncionario $agenteTransito
     *
     * @return CvCdoComparendo
     */
    public function setAgenteTransito(\JHWEB\PersonalBundle\Entity\PnalFuncionario $agenteTransito = null)
    {
        $this->agenteTransito = $agenteTransito;

        return $this;
    }

    /**
     * Get agenteTransito
     *
     * @return \JHWEB\PersonalBundle\Entity\PnalFuncionario
     */
    public function getAgenteTransito()
    {
        return $this->agenteTransito;
    }

    /**
     * Set consecutivo
     *
     * @param \JHWEB\PersonalBundle\Entity\PnalCfgCdoConsecutivo $consecutivo
     *
     * @return CvCdoComparendo
     */
    public function setConsecutivo(\JHWEB\PersonalBundle\Entity\PnalCfgCdoConsecutivo $consecutivo = null)
    {
        $this->consecutivo = $consecutivo;

        return $this;
    }

    /**
     * Get consecutivo
     *
     * @return \JHWEB\PersonalBundle\Entity\PnalCfgCdoConsecutivo
     */
    public function getConsecutivo()
    {
        return $this->consecutivo;
    }

    /**
     * Set acuerdoPago
     *
     * @param \JHWEB\FinancieroBundle\Entity\FroAcuerdoPago $acuerdoPago
     *
     * @return CvCdoComparendo
     */
    public function setAcuerdoPago(\JHWEB\FinancieroBundle\Entity\FroAcuerdoPago $acuerdoPago = null)
    {
        $this->acuerdoPago = $acuerdoPago;

        return $this;
    }

    /**
     * Get acuerdoPago
     *
     * @return \JHWEB\FinancieroBundle\Entity\FroAcuerdoPago
     */
    public function getAcuerdoPago()
    {
        return $this->acuerdoPago;
    }

    /**
     * Set estado
     *
     * @param \JHWEB\ContravencionalBundle\Entity\CvCdoCfgEstado $estado
     *
     * @return CvCdoComparendo
     */
    public function setEstado(\JHWEB\ContravencionalBundle\Entity\CvCdoCfgEstado $estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \JHWEB\ContravencionalBundle\Entity\CvCdoCfgEstado
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set inventarioDocumental
     *
     * @param \JHWEB\ContravencionalBundle\Entity\CvInventarioDocumental $inventarioDocumental
     *
     * @return CvCdoComparendo
     */
    public function setInventarioDocumental(\JHWEB\ContravencionalBundle\Entity\CvInventarioDocumental $inventarioDocumental = null)
    {
        $this->inventarioDocumental = $inventarioDocumental;

        return $this;
    }

    /**
     * Get inventarioDocumental
     *
     * @return \JHWEB\ContravencionalBundle\Entity\CvInventarioDocumental
     */
    public function getInventarioDocumental()
    {
        return $this->inventarioDocumental;
    }
}
