<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvCaracterizacion
 *
 * @ORM\Table(name="sv_caracterizacion")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvCaracterizacionRepository")
 */
class SvCaracterizacion
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
     * @ORM\Column(name="placa", type="string", length=6, nullable=true)
     */
    private $placa;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloCfgTipoVehiculo", inversedBy="caracterizaciones")
     **/
    protected $tipoVehiculo;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloCfgLinea", inversedBy="caracterizaciones")
     **/
    protected $linea;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloCfgColor", inversedBy="caracterizaciones")
     **/
    protected $color;

    /**
     * @var string
     *
     * @ORM\Column(name="chasis", type="string", length=150, nullable=true)
     */
    private $chasis;

    /**
     * @var string
     *
     * @ORM\Column(name="motor", type="string", length=150, nullable=true)
     */
    private $motor;

    /**
     * @var string
     *
     * @ORM\Column(name="cilindraje", type="string", length=150, nullable=true)
     */
    private $cilindraje;

    /**
     * @var string
     *
     * @ORM\Column(name="uso_vehiculo", type="string", length=150, nullable=true)
     */
    private $usoVehiculo;

    /**
     * @var int
     *
     * @ORM\Column(name="numero_interno_dpn", type="integer", length=150, nullable=true)
     */
    private $numeroInternoDpn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_vencimiento_soat", type="date")
     */
    private $fechaVencimientoSoat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_vencimiento_tecnomecanica", type="date")
     */
    private $fechaVencimientoTecnomecanica;

     /**
     * @var int
     *
     * @ORM\Column(name="numero_licencia_transito", type="integer", length=150, nullable=true)
     */
    private $numeroLicenciaTransito;

     /**
     * @var int
     *
     * @ORM\Column(name="numero_valvulas_cilindro", type="integer", length=150, nullable=true)
     */
    private $numeroValvulasCilindro;

     /**
     * @var int
     *
     * @ORM\Column(name="cantidad_cilindros", type="integer", length=150, nullable=true)
     */
    private $cantidadCilindros;

    /**
     * @var string
     *
     * @ORM\Column(name="turbo", type="string", length=150, nullable=true)
     */
    private $turbo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="tipo_direccion", type="string", length=150, nullable=true)
     */
    private $tipoDireccion;
    
    /**
     * @var string
     *
     * @ORM\Column(name="tipo_transicion", type="string", length=150, nullable=true)
     */
    private $tipoTransicion;
    
    /**
     * @var string
     *
     * @ORM\Column(name="tipo_rodamientos", type="string", length=150, nullable=true)
     */
    private $tipoRodamientos;
    
    /**
     * @var string
     *
     * @ORM\Column(name="numero_velocidades", type="string", length=150, nullable=true)
     */
    private $numeroVelocidades;
    
    /**
     * @var string
     *
     * @ORM\Column(name="suspension_delantera", type="string", length=150, nullable=true)
     */
    private $suspensionDelantera;
    
    /**
     * @var string
     *
     * @ORM\Column(name="suspension_trasera", type="string", length=150, nullable=true)
     */
    private $suspensionTrasera;
    
     /**
     * @var int
     *
     * @ORM\Column(name="numero_llantas", type="integer", length=150, nullable=true)
     */
    private $numeroLlantas;
    
     /**
     * @var int
     *
     * @ORM\Column(name="dimension_rines", type="integer", length=150, nullable=true)
     */
    private $dimensionRines;

    /**
     * @var string
     *
     * @ORM\Column(name="material_rines", type="string", length=150, nullable=true)
     */
    private $materialRines;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_frenos_delanteros", type="string", length=150, nullable=true)
     */
    private $tipoFrenosDelanteros;
    
    /**
     * @var string
     *
     * @ORM\Column(name="tipo_frenos_traseros", type="string", length=150, nullable=true)
     */
    private $tipoFrenosTraseros;

    /**
     * @var array
     *
     * @ORM\Column(name="tipos_prevencion", type="array", nullable=true)
     */
    private $tiposPrevencion;

    /**
     * @var array
     *
     * @ORM\Column(name="mantenimientos", type="array", nullable=true)
     */
    private $mantenimientos;


    //datos empresa
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserEmpresa", inversedBy="caracterizaciones")
     **/
    protected $empresa;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgMunicipio", inversedBy="caracterizaciones")
     **/
    protected $ciudad;

    /**
     * @var string
     *
     * @ORM\Column(name="nombres", type="string", length=255)
     */
    private $nombres;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=255)
     */
    private $apellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="cedula", type="string", length=255)
     */
    private $cedula;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgMunicipio", inversedBy="caracterizaciones")
     **/
    protected $lugarExpedicionDocumento;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserCfgGrupoSanguineo", inversedBy="caracterizaciones")
     **/
    protected $grupoSanguineo;

    /**
     * @var string
     *
     * @ORM\Column(name="clc", type="string", length=150, nullable=true)
     */
    private $clc;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_vigencia", type="date", nullable=true)
     */
    private $fechaVigencia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_nacimiento", type="date", nullable=true)
     */
    private $fechaNacimiento;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserCfgGenero", inversedBy="caracterizaciones")
     **/
    protected $genero;

    
    /**
     * @var string
     *
     * @ORM\Column(name="nivel_educativo", type="string", length=150, nullable=true)
     */
    private $nivelEducativo;

    /**
     * @var string
     *
     * @ORM\Column(name="grupo_trabajo", type="string", length=100)
     */
    private $grupoTrabajo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="otro_grupo_trabajo", type="string", length=100, nullable=true)
     */
    private $otroGrupoTrabajo;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_contrato", type="string", length=100)
     */
    private $tipoContrato;

    /**
     * @var string
     *
     * @ORM\Column(name="otro_tipo_contrato", type="string", length=100, nullable=true)
     */
    private $otroTipoContrato;

    /**
     * @var string
     *
     * @ORM\Column(name="experiencia_conduccion", type="string", length=255, nullable=true)
     */
    private $experienciaConduccion;

    /**
     * @var bool
     *
     * @ORM\Column(name="accidente_transito", type="boolean", nullable=true)
     */
    private $accidenteTransito;

    /**
     * @var string
     *
     * @ORM\Column(name="circunstancias", type="string", length=500, nullable=true)
     */
    private $circunstancias;

    /**
     * @var bool
     *
     * @ORM\Column(name="incidente", type="boolean", nullable=true)
     */
    private $incidente;

    /**
     * @var string
     *
     * @ORM\Column(name="frecuencia_desplazamiento", type="string", length=100, nullable=true)
     */
    private $frecuenciaDesplazamiento;

    /**
     * @var bool
     *
     * @ORM\Column(name="vehiculo_propio", type="boolean", nullable=true)
     */
    private $vehiculoPropio;

    /**
     * @var string
     *
     * @ORM\Column(name="planificacion_desplazamiento", type="string", length=100, nullable=true)
     */
    private $planificacionDesplazamiento;

    /**
     * @var string
     *
     * @ORM\Column(name="tiempo_antelacion", type="string", length=255, nullable=true)
     */
    private $tiempoAntelacion;

    /**
     * @var string
     *
     * @ORM\Column(name="medio_desplazamiento", type="string", length=100, nullable=true)
     */
    private $medioDesplazamiento;

    /**
     * @var string
     *
     * @ORM\Column(name="trayecto", type="string", length=50, nullable=true)
     */
    private $trayecto;

    /**
     * @var string
     *
     * @ORM\Column(name="tiempo_trayecto", type="string", length=50, nullable=true)
     */
    private $tiempoTrayecto;

    /**
     * @var string
     *
     * @ORM\Column(name="km_mensuales_recorridos", type="string", length=50, nullable=true)
     */
    private $kmMensualesRecorridos;

    /**
     * @var string
     *
     * @ORM\Column(name="principales_factores_riesgo", type="string", length=50, nullable=true)
     */
    private $principalFactorRiesgo;

    /**
     * @var string
     *
     * @ORM\Column(name="otro_factor_riesgo", type="string", length=50, nullable=true)
     */
    private $otroFactorRiesgo;

    /**
     * @var string
     *
     * @ORM\Column(name="causas_riesgo", type="string", length=50, nullable=true)
     */
    private $causaRiesgo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="otra_causa_riesgo", type="string", length=255, nullable=true)
     */
    private $otraCausaRiesgo;

    /**
     * @var string
     *
     * @ORM\Column(name="riesgo", type="string", length=255, nullable=true)
     */
    private $riesgo;

    /**
     * @var string
     *
     * @ORM\Column(name="propuesta_reduccion_riesgo", type="string", length=500, nullable=true)
     */
    private $propuestaReduccionRiesgo;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo = true;

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
     * Set placa
     *
     * @param string $placa
     *
     * @return SvCaracterizacion
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
     * Set chasis
     *
     * @param string $chasis
     *
     * @return SvCaracterizacion
     */
    public function setChasis($chasis)
    {
        $this->chasis = $chasis;

        return $this;
    }

    /**
     * Get chasis
     *
     * @return string
     */
    public function getChasis()
    {
        return $this->chasis;
    }

    /**
     * Set motor
     *
     * @param string $motor
     *
     * @return SvCaracterizacion
     */
    public function setMotor($motor)
    {
        $this->motor = $motor;

        return $this;
    }

    /**
     * Get motor
     *
     * @return string
     */
    public function getMotor()
    {
        return $this->motor;
    }

    /**
     * Set cilindraje
     *
     * @param string $cilindraje
     *
     * @return SvCaracterizacion
     */
    public function setCilindraje($cilindraje)
    {
        $this->cilindraje = $cilindraje;

        return $this;
    }

    /**
     * Get cilindraje
     *
     * @return string
     */
    public function getCilindraje()
    {
        return $this->cilindraje;
    }

    /**
     * Set usoVehiculo
     *
     * @param string $usoVehiculo
     *
     * @return SvCaracterizacion
     */
    public function setUsoVehiculo($usoVehiculo)
    {
        $this->usoVehiculo = $usoVehiculo;

        return $this;
    }

    /**
     * Get usoVehiculo
     *
     * @return string
     */
    public function getUsoVehiculo()
    {
        return $this->usoVehiculo;
    }

    /**
     * Set numeroInternoDpn
     *
     * @param integer $numeroInternoDpn
     *
     * @return SvCaracterizacion
     */
    public function setNumeroInternoDpn($numeroInternoDpn)
    {
        $this->numeroInternoDpn = $numeroInternoDpn;

        return $this;
    }

    /**
     * Get numeroInternoDpn
     *
     * @return integer
     */
    public function getNumeroInternoDpn()
    {
        return $this->numeroInternoDpn;
    }

    /**
     * Set fechaVencimientoSoat
     *
     * @param \DateTime $fechaVencimientoSoat
     *
     * @return SvCaracterizacion
     */
    public function setFechaVencimientoSoat($fechaVencimientoSoat)
    {
        $this->fechaVencimientoSoat = $fechaVencimientoSoat;

        return $this;
    }

    /**
     * Get fechaVencimientoSoat
     *
     * @return \DateTime
     */
    public function getFechaVencimientoSoat()
    {
        return $this->fechaVencimientoSoat;
    }

    /**
     * Set fechaVencimientoTecnomecanica
     *
     * @param \DateTime $fechaVencimientoTecnomecanica
     *
     * @return SvCaracterizacion
     */
    public function setFechaVencimientoTecnomecanica($fechaVencimientoTecnomecanica)
    {
        $this->fechaVencimientoTecnomecanica = $fechaVencimientoTecnomecanica;

        return $this;
    }

    /**
     * Get fechaVencimientoTecnomecanica
     *
     * @return \DateTime
     */
    public function getFechaVencimientoTecnomecanica()
    {
        return $this->fechaVencimientoTecnomecanica;
    }

    /**
     * Set numeroLicenciaTransito
     *
     * @param integer $numeroLicenciaTransito
     *
     * @return SvCaracterizacion
     */
    public function setNumeroLicenciaTransito($numeroLicenciaTransito)
    {
        $this->numeroLicenciaTransito = $numeroLicenciaTransito;

        return $this;
    }

    /**
     * Get numeroLicenciaTransito
     *
     * @return integer
     */
    public function getNumeroLicenciaTransito()
    {
        return $this->numeroLicenciaTransito;
    }

    /**
     * Set numeroValvulasCilindro
     *
     * @param integer $numeroValvulasCilindro
     *
     * @return SvCaracterizacion
     */
    public function setNumeroValvulasCilindro($numeroValvulasCilindro)
    {
        $this->numeroValvulasCilindro = $numeroValvulasCilindro;

        return $this;
    }

    /**
     * Get numeroValvulasCilindro
     *
     * @return integer
     */
    public function getNumeroValvulasCilindro()
    {
        return $this->numeroValvulasCilindro;
    }

    /**
     * Set cantidadCilindros
     *
     * @param integer $cantidadCilindros
     *
     * @return SvCaracterizacion
     */
    public function setCantidadCilindros($cantidadCilindros)
    {
        $this->cantidadCilindros = $cantidadCilindros;

        return $this;
    }

    /**
     * Get cantidadCilindros
     *
     * @return integer
     */
    public function getCantidadCilindros()
    {
        return $this->cantidadCilindros;
    }

    /**
     * Set turbo
     *
     * @param string $turbo
     *
     * @return SvCaracterizacion
     */
    public function setTurbo($turbo)
    {
        $this->turbo = $turbo;

        return $this;
    }

    /**
     * Get turbo
     *
     * @return string
     */
    public function getTurbo()
    {
        return $this->turbo;
    }

    /**
     * Set tipoDireccion
     *
     * @param string $tipoDireccion
     *
     * @return SvCaracterizacion
     */
    public function setTipoDireccion($tipoDireccion)
    {
        $this->tipoDireccion = $tipoDireccion;

        return $this;
    }

    /**
     * Get tipoDireccion
     *
     * @return string
     */
    public function getTipoDireccion()
    {
        return $this->tipoDireccion;
    }

    /**
     * Set tipoTransicion
     *
     * @param string $tipoTransicion
     *
     * @return SvCaracterizacion
     */
    public function setTipoTransicion($tipoTransicion)
    {
        $this->tipoTransicion = $tipoTransicion;

        return $this;
    }

    /**
     * Get tipoTransicion
     *
     * @return string
     */
    public function getTipoTransicion()
    {
        return $this->tipoTransicion;
    }

    /**
     * Set tipoRodamientos
     *
     * @param string $tipoRodamientos
     *
     * @return SvCaracterizacion
     */
    public function setTipoRodamientos($tipoRodamientos)
    {
        $this->tipoRodamientos = $tipoRodamientos;

        return $this;
    }

    /**
     * Get tipoRodamientos
     *
     * @return string
     */
    public function getTipoRodamientos()
    {
        return $this->tipoRodamientos;
    }

    /**
     * Set numeroVelocidades
     *
     * @param string $numeroVelocidades
     *
     * @return SvCaracterizacion
     */
    public function setNumeroVelocidades($numeroVelocidades)
    {
        $this->numeroVelocidades = $numeroVelocidades;

        return $this;
    }

    /**
     * Get numeroVelocidades
     *
     * @return string
     */
    public function getNumeroVelocidades()
    {
        return $this->numeroVelocidades;
    }

    /**
     * Set suspensionDelantera
     *
     * @param string $suspensionDelantera
     *
     * @return SvCaracterizacion
     */
    public function setSuspensionDelantera($suspensionDelantera)
    {
        $this->suspensionDelantera = $suspensionDelantera;

        return $this;
    }

    /**
     * Get suspensionDelantera
     *
     * @return string
     */
    public function getSuspensionDelantera()
    {
        return $this->suspensionDelantera;
    }

    /**
     * Set suspensionTrasera
     *
     * @param string $suspensionTrasera
     *
     * @return SvCaracterizacion
     */
    public function setSuspensionTrasera($suspensionTrasera)
    {
        $this->suspensionTrasera = $suspensionTrasera;

        return $this;
    }

    /**
     * Get suspensionTrasera
     *
     * @return string
     */
    public function getSuspensionTrasera()
    {
        return $this->suspensionTrasera;
    }

    /**
     * Set numeroLlantas
     *
     * @param integer $numeroLlantas
     *
     * @return SvCaracterizacion
     */
    public function setNumeroLlantas($numeroLlantas)
    {
        $this->numeroLlantas = $numeroLlantas;

        return $this;
    }

    /**
     * Get numeroLlantas
     *
     * @return integer
     */
    public function getNumeroLlantas()
    {
        return $this->numeroLlantas;
    }

    /**
     * Set dimensionRines
     *
     * @param integer $dimensionRines
     *
     * @return SvCaracterizacion
     */
    public function setDimensionRines($dimensionRines)
    {
        $this->dimensionRines = $dimensionRines;

        return $this;
    }

    /**
     * Get dimensionRines
     *
     * @return integer
     */
    public function getDimensionRines()
    {
        return $this->dimensionRines;
    }

    /**
     * Set materialRines
     *
     * @param string $materialRines
     *
     * @return SvCaracterizacion
     */
    public function setMaterialRines($materialRines)
    {
        $this->materialRines = $materialRines;

        return $this;
    }

    /**
     * Get materialRines
     *
     * @return string
     */
    public function getMaterialRines()
    {
        return $this->materialRines;
    }

    /**
     * Set tipoFrenosDelanteros
     *
     * @param string $tipoFrenosDelanteros
     *
     * @return SvCaracterizacion
     */
    public function setTipoFrenosDelanteros($tipoFrenosDelanteros)
    {
        $this->tipoFrenosDelanteros = $tipoFrenosDelanteros;

        return $this;
    }

    /**
     * Get tipoFrenosDelanteros
     *
     * @return string
     */
    public function getTipoFrenosDelanteros()
    {
        return $this->tipoFrenosDelanteros;
    }

    /**
     * Set tipoFrenosTraseros
     *
     * @param string $tipoFrenosTraseros
     *
     * @return SvCaracterizacion
     */
    public function setTipoFrenosTraseros($tipoFrenosTraseros)
    {
        $this->tipoFrenosTraseros = $tipoFrenosTraseros;

        return $this;
    }

    /**
     * Get tipoFrenosTraseros
     *
     * @return string
     */
    public function getTipoFrenosTraseros()
    {
        return $this->tipoFrenosTraseros;
    }

    /**
     * Set tiposPrevencion
     *
     * @param array $tiposPrevencion
     *
     * @return SvCaracterizacion
     */
    public function setTiposPrevencion($tiposPrevencion)
    {
        $this->tiposPrevencion = $tiposPrevencion;

        return $this;
    }

    /**
     * Get tiposPrevencion
     *
     * @return array
     */
    public function getTiposPrevencion()
    {
        return $this->tiposPrevencion;
    }

    /**
     * Set mantenimientos
     *
     * @param array $mantenimientos
     *
     * @return SvCaracterizacion
     */
    public function setMantenimientos($mantenimientos)
    {
        $this->mantenimientos = $mantenimientos;

        return $this;
    }

    /**
     * Get mantenimientos
     *
     * @return array
     */
    public function getMantenimientos()
    {
        return $this->mantenimientos;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return SvCaracterizacion
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
     * Set nombres
     *
     * @param string $nombres
     *
     * @return SvCaracterizacion
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;

        return $this;
    }

    /**
     * Get nombres
     *
     * @return string
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     *
     * @return SvCaracterizacion
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set cedula
     *
     * @param string $cedula
     *
     * @return SvCaracterizacion
     */
    public function setCedula($cedula)
    {
        $this->cedula = $cedula;

        return $this;
    }

    /**
     * Get cedula
     *
     * @return string
     */
    public function getCedula()
    {
        return $this->cedula;
    }

    /**
     * Set clc
     *
     * @param string $clc
     *
     * @return SvCaracterizacion
     */
    public function setClc($clc)
    {
        $this->clc = $clc;

        return $this;
    }

    /**
     * Get clc
     *
     * @return string
     */
    public function getClc()
    {
        return $this->clc;
    }

    /**
     * Set fechaVigencia
     *
     * @param \DateTime $fechaVigencia
     *
     * @return SvCaracterizacion
     */
    public function setFechaVigencia($fechaVigencia)
    {
        $this->fechaVigencia = $fechaVigencia;

        return $this;
    }

    /**
     * Get fechaVigencia
     *
     * @return \DateTime
     */
    public function getFechaVigencia()
    {
        return $this->fechaVigencia;
    }

    /**
     * Set fechaNacimiento
     *
     * @param \DateTime $fechaNacimiento
     *
     * @return SvCaracterizacion
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * Get fechaNacimiento
     *
     * @return \DateTime
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    /**
     * Set nivelEducativo
     *
     * @param string $nivelEducativo
     *
     * @return SvCaracterizacion
     */
    public function setNivelEducativo($nivelEducativo)
    {
        $this->nivelEducativo = $nivelEducativo;

        return $this;
    }

    /**
     * Get nivelEducativo
     *
     * @return string
     */
    public function getNivelEducativo()
    {
        return $this->nivelEducativo;
    }

    /**
     * Set grupoTrabajo
     *
     * @param string $grupoTrabajo
     *
     * @return SvCaracterizacion
     */
    public function setGrupoTrabajo($grupoTrabajo)
    {
        $this->grupoTrabajo = $grupoTrabajo;

        return $this;
    }

    /**
     * Get grupoTrabajo
     *
     * @return string
     */
    public function getGrupoTrabajo()
    {
        return $this->grupoTrabajo;
    }

    /**
     * Set otroGrupoTrabajo
     *
     * @param string $otroGrupoTrabajo
     *
     * @return SvCaracterizacion
     */
    public function setOtroGrupoTrabajo($otroGrupoTrabajo)
    {
        $this->otroGrupoTrabajo = $otroGrupoTrabajo;

        return $this;
    }

    /**
     * Get otroGrupoTrabajo
     *
     * @return string
     */
    public function getOtroGrupoTrabajo()
    {
        return $this->otroGrupoTrabajo;
    }

    /**
     * Set tipoContrato
     *
     * @param string $tipoContrato
     *
     * @return SvCaracterizacion
     */
    public function setTipoContrato($tipoContrato)
    {
        $this->tipoContrato = $tipoContrato;

        return $this;
    }

    /**
     * Get tipoContrato
     *
     * @return string
     */
    public function getTipoContrato()
    {
        return $this->tipoContrato;
    }

    /**
     * Set otroTipoContrato
     *
     * @param string $otroTipoContrato
     *
     * @return SvCaracterizacion
     */
    public function setOtroTipoContrato($otroTipoContrato)
    {
        $this->otroTipoContrato = $otroTipoContrato;

        return $this;
    }

    /**
     * Get otroTipoContrato
     *
     * @return string
     */
    public function getOtroTipoContrato()
    {
        return $this->otroTipoContrato;
    }

    /**
     * Set experienciaConduccion
     *
     * @param string $experienciaConduccion
     *
     * @return SvCaracterizacion
     */
    public function setExperienciaConduccion($experienciaConduccion)
    {
        $this->experienciaConduccion = $experienciaConduccion;

        return $this;
    }

    /**
     * Get experienciaConduccion
     *
     * @return string
     */
    public function getExperienciaConduccion()
    {
        return $this->experienciaConduccion;
    }

    /**
     * Set accidenteTransito
     *
     * @param boolean $accidenteTransito
     *
     * @return SvCaracterizacion
     */
    public function setAccidenteTransito($accidenteTransito)
    {
        $this->accidenteTransito = $accidenteTransito;

        return $this;
    }

    /**
     * Get accidenteTransito
     *
     * @return boolean
     */
    public function getAccidenteTransito()
    {
        return $this->accidenteTransito;
    }

    /**
     * Set circunstancias
     *
     * @param string $circunstancias
     *
     * @return SvCaracterizacion
     */
    public function setCircunstancias($circunstancias)
    {
        $this->circunstancias = $circunstancias;

        return $this;
    }

    /**
     * Get circunstancias
     *
     * @return string
     */
    public function getCircunstancias()
    {
        return $this->circunstancias;
    }

    /**
     * Set incidente
     *
     * @param boolean $incidente
     *
     * @return SvCaracterizacion
     */
    public function setIncidente($incidente)
    {
        $this->incidente = $incidente;

        return $this;
    }

    /**
     * Get incidente
     *
     * @return boolean
     */
    public function getIncidente()
    {
        return $this->incidente;
    }

    /**
     * Set frecuenciaDesplazamiento
     *
     * @param string $frecuenciaDesplazamiento
     *
     * @return SvCaracterizacion
     */
    public function setFrecuenciaDesplazamiento($frecuenciaDesplazamiento)
    {
        $this->frecuenciaDesplazamiento = $frecuenciaDesplazamiento;

        return $this;
    }

    /**
     * Get frecuenciaDesplazamiento
     *
     * @return string
     */
    public function getFrecuenciaDesplazamiento()
    {
        return $this->frecuenciaDesplazamiento;
    }

    /**
     * Set vehiculoPropio
     *
     * @param boolean $vehiculoPropio
     *
     * @return SvCaracterizacion
     */
    public function setVehiculoPropio($vehiculoPropio)
    {
        $this->vehiculoPropio = $vehiculoPropio;

        return $this;
    }

    /**
     * Get vehiculoPropio
     *
     * @return boolean
     */
    public function getVehiculoPropio()
    {
        return $this->vehiculoPropio;
    }

    /**
     * Set planificacionDesplazamiento
     *
     * @param string $planificacionDesplazamiento
     *
     * @return SvCaracterizacion
     */
    public function setPlanificacionDesplazamiento($planificacionDesplazamiento)
    {
        $this->planificacionDesplazamiento = $planificacionDesplazamiento;

        return $this;
    }

    /**
     * Get planificacionDesplazamiento
     *
     * @return string
     */
    public function getPlanificacionDesplazamiento()
    {
        return $this->planificacionDesplazamiento;
    }

    /**
     * Set tiempoAntelacion
     *
     * @param string $tiempoAntelacion
     *
     * @return SvCaracterizacion
     */
    public function setTiempoAntelacion($tiempoAntelacion)
    {
        $this->tiempoAntelacion = $tiempoAntelacion;

        return $this;
    }

    /**
     * Get tiempoAntelacion
     *
     * @return string
     */
    public function getTiempoAntelacion()
    {
        return $this->tiempoAntelacion;
    }

    /**
     * Set medioDesplazamiento
     *
     * @param string $medioDesplazamiento
     *
     * @return SvCaracterizacion
     */
    public function setMedioDesplazamiento($medioDesplazamiento)
    {
        $this->medioDesplazamiento = $medioDesplazamiento;

        return $this;
    }

    /**
     * Get medioDesplazamiento
     *
     * @return string
     */
    public function getMedioDesplazamiento()
    {
        return $this->medioDesplazamiento;
    }

    /**
     * Set trayecto
     *
     * @param string $trayecto
     *
     * @return SvCaracterizacion
     */
    public function setTrayecto($trayecto)
    {
        $this->trayecto = $trayecto;

        return $this;
    }

    /**
     * Get trayecto
     *
     * @return string
     */
    public function getTrayecto()
    {
        return $this->trayecto;
    }

    /**
     * Set tiempoTrayecto
     *
     * @param string $tiempoTrayecto
     *
     * @return SvCaracterizacion
     */
    public function setTiempoTrayecto($tiempoTrayecto)
    {
        $this->tiempoTrayecto = $tiempoTrayecto;

        return $this;
    }

    /**
     * Get tiempoTrayecto
     *
     * @return string
     */
    public function getTiempoTrayecto()
    {
        return $this->tiempoTrayecto;
    }

    /**
     * Set kmMensualesRecorridos
     *
     * @param string $kmMensualesRecorridos
     *
     * @return SvCaracterizacion
     */
    public function setKmMensualesRecorridos($kmMensualesRecorridos)
    {
        $this->kmMensualesRecorridos = $kmMensualesRecorridos;

        return $this;
    }

    /**
     * Get kmMensualesRecorridos
     *
     * @return string
     */
    public function getKmMensualesRecorridos()
    {
        return $this->kmMensualesRecorridos;
    }

    /**
     * Set principalFactorRiesgo
     *
     * @param string $principalFactorRiesgo
     *
     * @return SvCaracterizacion
     */
    public function setPrincipalFactorRiesgo($principalFactorRiesgo)
    {
        $this->principalFactorRiesgo = $principalFactorRiesgo;

        return $this;
    }

    /**
     * Get principalFactorRiesgo
     *
     * @return string
     */
    public function getPrincipalFactorRiesgo()
    {
        return $this->principalFactorRiesgo;
    }

    /**
     * Set otroFactorRiesgo
     *
     * @param string $otroFactorRiesgo
     *
     * @return SvCaracterizacion
     */
    public function setOtroFactorRiesgo($otroFactorRiesgo)
    {
        $this->otroFactorRiesgo = $otroFactorRiesgo;

        return $this;
    }

    /**
     * Get otroFactorRiesgo
     *
     * @return string
     */
    public function getOtroFactorRiesgo()
    {
        return $this->otroFactorRiesgo;
    }

    /**
     * Set causaRiesgo
     *
     * @param string $causaRiesgo
     *
     * @return SvCaracterizacion
     */
    public function setCausaRiesgo($causaRiesgo)
    {
        $this->causaRiesgo = $causaRiesgo;

        return $this;
    }

    /**
     * Get causaRiesgo
     *
     * @return string
     */
    public function getCausaRiesgo()
    {
        return $this->causaRiesgo;
    }

    /**
     * Set otraCausaRiesgo
     *
     * @param string $otraCausaRiesgo
     *
     * @return SvCaracterizacion
     */
    public function setOtraCausaRiesgo($otraCausaRiesgo)
    {
        $this->otraCausaRiesgo = $otraCausaRiesgo;

        return $this;
    }

    /**
     * Get otraCausaRiesgo
     *
     * @return string
     */
    public function getOtraCausaRiesgo()
    {
        return $this->otraCausaRiesgo;
    }

    /**
     * Set riesgo
     *
     * @param string $riesgo
     *
     * @return SvCaracterizacion
     */
    public function setRiesgo($riesgo)
    {
        $this->riesgo = $riesgo;

        return $this;
    }

    /**
     * Get riesgo
     *
     * @return string
     */
    public function getRiesgo()
    {
        return $this->riesgo;
    }

    /**
     * Set propuestaReduccionRiesgo
     *
     * @param string $propuestaReduccionRiesgo
     *
     * @return SvCaracterizacion
     */
    public function setPropuestaReduccionRiesgo($propuestaReduccionRiesgo)
    {
        $this->propuestaReduccionRiesgo = $propuestaReduccionRiesgo;

        return $this;
    }

    /**
     * Get propuestaReduccionRiesgo
     *
     * @return string
     */
    public function getPropuestaReduccionRiesgo()
    {
        return $this->propuestaReduccionRiesgo;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return SvCaracterizacion
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
     * Set tipoVehiculo
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgTipoVehiculo $tipoVehiculo
     *
     * @return SvCaracterizacion
     */
    public function setTipoVehiculo(\JHWEB\VehiculoBundle\Entity\VhloCfgTipoVehiculo $tipoVehiculo = null)
    {
        $this->tipoVehiculo = $tipoVehiculo;

        return $this;
    }

    /**
     * Get tipoVehiculo
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgTipoVehiculo
     */
    public function getTipoVehiculo()
    {
        return $this->tipoVehiculo;
    }

    /**
     * Set linea
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgLinea $linea
     *
     * @return SvCaracterizacion
     */
    public function setLinea(\JHWEB\VehiculoBundle\Entity\VhloCfgLinea $linea = null)
    {
        $this->linea = $linea;

        return $this;
    }

    /**
     * Get linea
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgLinea
     */
    public function getLinea()
    {
        return $this->linea;
    }

    /**
     * Set color
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgColor $color
     *
     * @return SvCaracterizacion
     */
    public function setColor(\JHWEB\VehiculoBundle\Entity\VhloCfgColor $color = null)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgColor
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set empresa
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserEmpresa $empresa
     *
     * @return SvCaracterizacion
     */
    public function setEmpresa(\JHWEB\UsuarioBundle\Entity\UserEmpresa $empresa = null)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserEmpresa
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set ciudad
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgMunicipio $ciudad
     *
     * @return SvCaracterizacion
     */
    public function setCiudad(\JHWEB\ConfigBundle\Entity\CfgMunicipio $ciudad = null)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get ciudad
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgMunicipio
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * Set lugarExpedicionDocumento
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgMunicipio $lugarExpedicionDocumento
     *
     * @return SvCaracterizacion
     */
    public function setLugarExpedicionDocumento(\JHWEB\ConfigBundle\Entity\CfgMunicipio $lugarExpedicionDocumento = null)
    {
        $this->lugarExpedicionDocumento = $lugarExpedicionDocumento;

        return $this;
    }

    /**
     * Get lugarExpedicionDocumento
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgMunicipio
     */
    public function getLugarExpedicionDocumento()
    {
        return $this->lugarExpedicionDocumento;
    }

    /**
     * Set grupoSanguineo
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserCfgGrupoSanguineo $grupoSanguineo
     *
     * @return SvCaracterizacion
     */
    public function setGrupoSanguineo(\JHWEB\UsuarioBundle\Entity\UserCfgGrupoSanguineo $grupoSanguineo = null)
    {
        $this->grupoSanguineo = $grupoSanguineo;

        return $this;
    }

    /**
     * Get grupoSanguineo
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserCfgGrupoSanguineo
     */
    public function getGrupoSanguineo()
    {
        return $this->grupoSanguineo;
    }

    /**
     * Set genero
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserCfgGenero $genero
     *
     * @return SvCaracterizacion
     */
    public function setGenero(\JHWEB\UsuarioBundle\Entity\UserCfgGenero $genero = null)
    {
        $this->genero = $genero;

        return $this;
    }

    /**
     * Get genero
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserCfgGenero
     */
    public function getGenero()
    {
        return $this->genero;
    }
}
