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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserEmpresa", inversedBy="empresas")
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
     * Set ciudad
     *
     * @param string $ciudad
     *
     * @return SvCaracterizacion
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
     * Set edad
     *
     * @param integer $edad
     *
     * @return SvCaracterizacion
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
     * @return SvCaracterizacion
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
}
