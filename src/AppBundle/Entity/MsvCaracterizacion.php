<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MsvCaracterizacion
 *
 * @ORM\Table(name="msv_caracterizacion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MsvCaracterizacionRepository")
 */
class MsvCaracterizacion
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Empresa", inversedBy="empresas")
     **/
    protected $empresa;

    /**
     * @var string
     *
     * @ORM\Column(name="ciudad", type="string", length=150, nullable=true)
     */
    private $ciudad;

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
     * @var string
     *
     * @ORM\Column(name="lugar_expedicion", type="string", length=255, nullable=true)
     */
    private $lugarExpedicion;

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
     * @var int
     *
     * @ORM\Column(name="edad", type="integer")
     */
    private $edad;

    /**
     * @var string
     *
     * @ORM\Column(name="genero", type="string", length=50)
     */
    private $genero;

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
     * @ORM\Column(name="estado_infraestructura_factor_riesgo", type="string", length=50, nullable=true)
     */
    private $estadoInfraestructuraFactorRiesgo;

    /**
     * @var string
     *
     * @ORM\Column(name="organizacion_trabajo_factor_riesgo", type="string", length=50, nullable=true)
     */
    private $organizacionTrabajoFactorRiesgo;

    /**
     * @var string
     *
     * @ORM\Column(name="propia_conduccion_factor_riesgo", type="string", length=50, nullable=true)
     */
    private $propiaConduccionFactorRiesgo;

    /**
     * @var string
     *
     * @ORM\Column(name="otro_factor_riesgo", type="string", length=50, nullable=true)
     */
    private $otroFactorRiesgo;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="intensidad_trafico_causa_riesgo", type="string", length=50, nullable=true)
     */
    private $intensidadTraficoCausaRiesgo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="condicion_climatologica_causa_riesgo", type="string", length=50, nullable=true)
     */
    private $condicionClimatologicaCausaRiesgo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="tipo_vehiculo_causa_riesgo", type="string", length=50, nullable=true)
     */
    private $tipoVehiculoCausaRiesgo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="organizacion_trabajo_causa_riesgo", type="string", length=50, nullable=true)
     */
    private $organizacionTrabajoCausaRiesgo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="propia_conduccion_causa_riesgo", type="string", length=50, nullable=true)
     */
    private $propiaConduccionCausaRiesgo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="estado_causa_riesgo", type="string", length=50, nullable=true)
     */
    private $estadoCausaRiesgo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="otro_conductor_causa_riesgo", type="string", length=50, nullable=true)
     */
    private $otroConductorCausaRiesgo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="estado_infraestructura_causa_riesgo", type="string", length=50, nullable=true)
     */
    private $estadoInfraestructuraCausaRiesgo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="falta_informacion_causa_riesgo", type="string", length=50, nullable=true)
     */
    private $faltaInformacionCausaRiesgo;


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
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado = true;

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
     * @return MsvCaracterizacion
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
     * Set ciudad
     *
     * @param string $ciudad
     *
     * @return MsvCaracterizacion
     */
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get ciudad
     *
     * @return string
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * Set nombres
     *
     * @param string $nombres
     *
     * @return MsvCaracterizacion
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
     * @return MsvCaracterizacion
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
     * @return MsvCaracterizacion
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
     * Set lugarExpedicion
     *
     * @param string $lugarExpedicion
     *
     * @return MsvCaracterizacion
     */
    public function setLugarExpedicion($lugarExpedicion)
    {
        $this->lugarExpedicion = $lugarExpedicion;

        return $this;
    }

    /**
     * Get lugarExpedicion
     *
     * @return string
     */
    public function getLugarExpedicion()
    {
        return $this->lugarExpedicion;
    }

    /**
     * Set clc
     *
     * @param string $clc
     *
     * @return MsvCaracterizacion
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
     * @return MsvCaracterizacion
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
     * Set edad
     *
     * @param integer $edad
     *
     * @return MsvCaracterizacion
     */
    public function setEdad($edad)
    {
        $this->edad = $edad;

        return $this;
    }

    /**
     * Get edad
     *
     * @return integer
     */
    public function getEdad()
    {
        return $this->edad;
    }

    /**
     * Set genero
     *
     * @param string $genero
     *
     * @return MsvCaracterizacion
     */
    public function setGenero($genero)
    {
        $this->genero = $genero;

        return $this;
    }

    /**
     * Get genero
     *
     * @return string
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * Set grupoTrabajo
     *
     * @param string $grupoTrabajo
     *
     * @return MsvCaracterizacion
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
     * @return MsvCaracterizacion
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
     * @return MsvCaracterizacion
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
     * @return MsvCaracterizacion
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
     * @return MsvCaracterizacion
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
     * @return MsvCaracterizacion
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
     * @return MsvCaracterizacion
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
     * @return MsvCaracterizacion
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
     * @return MsvCaracterizacion
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
     * @return MsvCaracterizacion
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
     * @return MsvCaracterizacion
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
     * @return MsvCaracterizacion
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
     * @return MsvCaracterizacion
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
     * @return MsvCaracterizacion
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
     * @return MsvCaracterizacion
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
     * @return MsvCaracterizacion
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
     * Set estadoInfraestructuraFactorRiesgo
     *
     * @param string $estadoInfraestructuraFactorRiesgo
     *
     * @return MsvCaracterizacion
     */
    public function setEstadoInfraestructuraFactorRiesgo($estadoInfraestructuraFactorRiesgo)
    {
        $this->estadoInfraestructuraFactorRiesgo = $estadoInfraestructuraFactorRiesgo;

        return $this;
    }

    /**
     * Get estadoInfraestructuraFactorRiesgo
     *
     * @return string
     */
    public function getEstadoInfraestructuraFactorRiesgo()
    {
        return $this->estadoInfraestructuraFactorRiesgo;
    }

    /**
     * Set organizacionTrabajoFactorRiesgo
     *
     * @param string $organizacionTrabajoFactorRiesgo
     *
     * @return MsvCaracterizacion
     */
    public function setOrganizacionTrabajoFactorRiesgo($organizacionTrabajoFactorRiesgo)
    {
        $this->organizacionTrabajoFactorRiesgo = $organizacionTrabajoFactorRiesgo;

        return $this;
    }

    /**
     * Get organizacionTrabajoFactorRiesgo
     *
     * @return string
     */
    public function getOrganizacionTrabajoFactorRiesgo()
    {
        return $this->organizacionTrabajoFactorRiesgo;
    }

    /**
     * Set propiaConduccionFactorRiesgo
     *
     * @param string $propiaConduccionFactorRiesgo
     *
     * @return MsvCaracterizacion
     */
    public function setPropiaConduccionFactorRiesgo($propiaConduccionFactorRiesgo)
    {
        $this->propiaConduccionFactorRiesgo = $propiaConduccionFactorRiesgo;

        return $this;
    }

    /**
     * Get propiaConduccionFactorRiesgo
     *
     * @return string
     */
    public function getPropiaConduccionFactorRiesgo()
    {
        return $this->propiaConduccionFactorRiesgo;
    }

    /**
     * Set otroFactorRiesgo
     *
     * @param string $otroFactorRiesgo
     *
     * @return MsvCaracterizacion
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
     * Set intensidadTraficoCausaRiesgo
     *
     * @param string $intensidadTraficoCausaRiesgo
     *
     * @return MsvCaracterizacion
     */
    public function setIntensidadTraficoCausaRiesgo($intensidadTraficoCausaRiesgo)
    {
        $this->intensidadTraficoCausaRiesgo = $intensidadTraficoCausaRiesgo;

        return $this;
    }

    /**
     * Get intensidadTraficoCausaRiesgo
     *
     * @return string
     */
    public function getIntensidadTraficoCausaRiesgo()
    {
        return $this->intensidadTraficoCausaRiesgo;
    }

    /**
     * Set condicionClimatologicaCausaRiesgo
     *
     * @param string $condicionClimatologicaCausaRiesgo
     *
     * @return MsvCaracterizacion
     */
    public function setCondicionClimatologicaCausaRiesgo($condicionClimatologicaCausaRiesgo)
    {
        $this->condicionClimatologicaCausaRiesgo = $condicionClimatologicaCausaRiesgo;

        return $this;
    }

    /**
     * Get condicionClimatologicaCausaRiesgo
     *
     * @return string
     */
    public function getCondicionClimatologicaCausaRiesgo()
    {
        return $this->condicionClimatologicaCausaRiesgo;
    }

    /**
     * Set tipoVehiculoCausaRiesgo
     *
     * @param string $tipoVehiculoCausaRiesgo
     *
     * @return MsvCaracterizacion
     */
    public function setTipoVehiculoCausaRiesgo($tipoVehiculoCausaRiesgo)
    {
        $this->tipoVehiculoCausaRiesgo = $tipoVehiculoCausaRiesgo;

        return $this;
    }

    /**
     * Get tipoVehiculoCausaRiesgo
     *
     * @return string
     */
    public function getTipoVehiculoCausaRiesgo()
    {
        return $this->tipoVehiculoCausaRiesgo;
    }

    /**
     * Set organizacionTrabajoCausaRiesgo
     *
     * @param string $organizacionTrabajoCausaRiesgo
     *
     * @return MsvCaracterizacion
     */
    public function setOrganizacionTrabajoCausaRiesgo($organizacionTrabajoCausaRiesgo)
    {
        $this->organizacionTrabajoCausaRiesgo = $organizacionTrabajoCausaRiesgo;

        return $this;
    }

    /**
     * Get organizacionTrabajoCausaRiesgo
     *
     * @return string
     */
    public function getOrganizacionTrabajoCausaRiesgo()
    {
        return $this->organizacionTrabajoCausaRiesgo;
    }

    /**
     * Set propiaConduccionCausaRiesgo
     *
     * @param string $propiaConduccionCausaRiesgo
     *
     * @return MsvCaracterizacion
     */
    public function setPropiaConduccionCausaRiesgo($propiaConduccionCausaRiesgo)
    {
        $this->propiaConduccionCausaRiesgo = $propiaConduccionCausaRiesgo;

        return $this;
    }

    /**
     * Get propiaConduccionCausaRiesgo
     *
     * @return string
     */
    public function getPropiaConduccionCausaRiesgo()
    {
        return $this->propiaConduccionCausaRiesgo;
    }

    /**
     * Set estadoCausaRiesgo
     *
     * @param string $estadoCausaRiesgo
     *
     * @return MsvCaracterizacion
     */
    public function setEstadoCausaRiesgo($estadoCausaRiesgo)
    {
        $this->estadoCausaRiesgo = $estadoCausaRiesgo;

        return $this;
    }

    /**
     * Get estadoCausaRiesgo
     *
     * @return string
     */
    public function getEstadoCausaRiesgo()
    {
        return $this->estadoCausaRiesgo;
    }

    /**
     * Set otroConductorCausaRiesgo
     *
     * @param string $otroConductorCausaRiesgo
     *
     * @return MsvCaracterizacion
     */
    public function setOtroConductorCausaRiesgo($otroConductorCausaRiesgo)
    {
        $this->otroConductorCausaRiesgo = $otroConductorCausaRiesgo;

        return $this;
    }

    /**
     * Get otroConductorCausaRiesgo
     *
     * @return string
     */
    public function getOtroConductorCausaRiesgo()
    {
        return $this->otroConductorCausaRiesgo;
    }

    /**
     * Set estadoInfraestructuraCausaRiesgo
     *
     * @param string $estadoInfraestructuraCausaRiesgo
     *
     * @return MsvCaracterizacion
     */
    public function setEstadoInfraestructuraCausaRiesgo($estadoInfraestructuraCausaRiesgo)
    {
        $this->estadoInfraestructuraCausaRiesgo = $estadoInfraestructuraCausaRiesgo;

        return $this;
    }

    /**
     * Get estadoInfraestructuraCausaRiesgo
     *
     * @return string
     */
    public function getEstadoInfraestructuraCausaRiesgo()
    {
        return $this->estadoInfraestructuraCausaRiesgo;
    }

    /**
     * Set faltaInformacionCausaRiesgo
     *
     * @param string $faltaInformacionCausaRiesgo
     *
     * @return MsvCaracterizacion
     */
    public function setFaltaInformacionCausaRiesgo($faltaInformacionCausaRiesgo)
    {
        $this->faltaInformacionCausaRiesgo = $faltaInformacionCausaRiesgo;

        return $this;
    }

    /**
     * Get faltaInformacionCausaRiesgo
     *
     * @return string
     */
    public function getFaltaInformacionCausaRiesgo()
    {
        return $this->faltaInformacionCausaRiesgo;
    }

    /**
     * Set otraCausaRiesgo
     *
     * @param string $otraCausaRiesgo
     *
     * @return MsvCaracterizacion
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
     * @return MsvCaracterizacion
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
     * @return MsvCaracterizacion
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
     * Set estado
     *
     * @param boolean $estado
     *
     * @return MsvCaracterizacion
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
     * Set empresa
     *
     * @param \AppBundle\Entity\Empresa $empresa
     *
     * @return MsvCaracterizacion
     */
    public function setEmpresa(\AppBundle\Entity\Empresa $empresa = null)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \AppBundle\Entity\Empresa
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }
}
