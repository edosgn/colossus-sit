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
     * @ORM\Column(name="expediente", type="string", length=255, nullable=true)
     */
    private $expediente;

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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoIdentificacion", inversedBy="comparendos")
     **/
    protected $infractorTipoIdentificacion;

    /**
     * @var int
     *
     * @ORM\Column(name="infractor_identificacion", type="bigint", length=20)
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\OrganismoTransito", inversedBy="comparendos")
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoIdentificacion", inversedBy="comparendos")
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
    
    /****************************Llaves foraneas****************************/

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Municipio", inversedBy="comparendos")
     **/
    protected $municipio;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MflInfraccion", inversedBy="comparendos")
     **/
    protected $infraccion;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\OrganismoTransito", inversedBy="comparendos")
     **/
    protected $organismoTransitoMatriculado;

    /**
     * @var string
     *
     * @ORM\Column(name="servicio", type="string", length=255)
     */
    protected $servicio;
    
    /**
     * @var string
     *
     * @ORM\Column(name="clase", type="string", length=255)
     */
    protected $clase;
    
    /**
     * @var string
     *
     * @ORM\Column(name="radio_accion", type="string", length=255, nullable=true)
     */
    private $radioAccion;

    /**
     * @var string
     *
     * @ORM\Column(name="modalidad_transporte", type="string", length=255, nullable=true)
     */   
    private $modalidadTransporte;
    
    /**
     * @var string
     *
     * @ORM\Column(name="transporte_pasajero", type="string", length=255, nullable=true )
     */
    private $transportePasajero;

    /**
     * @var string
     *
     * @ORM\Column(name="transporte_especial", type="string", length=255, nullable=true)
     */
    private $transporteEspecial;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CfgTipoInfractor", inversedBy="comparendos")
     **/
    protected $tipoInfractor;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfiguracionBundle\Entity\CfgOrganismoTransito", inversedBy="comparendos")
     **/
    protected $organismoTransito;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\PersonalBundle\Entity\PnalFuncionario", inversedBy="comparendos")
     **/
    protected $agenteTransito;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\PersonalBundle\Entity\PnalComparendo", inversedBy="comparendos")
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

