<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvIpat
 *
 * @ORM\Table(name="sv_ipat")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvIpatRepository")
 */
class SvIpat
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
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvIpatConsecutivo", inversedBy="ipats")
     */
    private $consecutivo;

    /**
     * @var string
     *
     * @ORM\Column(name="lugar", type="string", nullable = true)
     */
    private $lugar;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_accidente", type="date", nullable = true)
     */
    private $fechaAccidente;

    /**
     * @var string
     *
     * @ORM\Column(name="dia_accidente", type="string", nullable = true)
     */
    private $diaAccidente;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_accidente", type="time", nullable = true)
     */
    private $horaAccidente;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_levantamiento", type="date", nullable = true)
     */
    private $fechaLevantamiento;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_levantamiento", type="time", nullable = true)
     */
    private $horaLevantamiento;

    /** @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgGravedadAccidente", inversedBy="gravedades")
     */
    private $gravedadAccidente;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgClaseAccidente", inversedBy="clasesaccidentes")
     */
    private $claseAccidente;

    /**
     * @var string
     *
     * @ORM\Column(name="otro_clase_accidente", type="string", nullable = true)
     */
    private $otroClaseAccidente;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgClaseChoque", inversedBy="choquescon")
     */
    private $claseChoque;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgObjetoFijo", inversedBy="objetosfijos")
     */
    private $objetoFijo;

    /**
     * @var string
     *
     * @ORM\Column(name="otro_objeto_fijo", type="string", nullable = true)
     */
    private $otroObjetoFijo;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgArea", inversedBy="areas")
     */
    private $area;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgTipoArea", inversedBy="tiposareas")
     */
    private $tipoArea;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgTipoVia", inversedBy="tiposvias")
     */
    private $tipoVia;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgCardinalidad", inversedBy="cardinalidades")
     */
    private $cardinalidad;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgSector", inversedBy="sectores")
     */
    private $sector;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgZona", inversedBy="zonas")
     */
    private $zona;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgDisenio", inversedBy="disenios")
     */
    private $disenio;

    /**
     * @var string
     *
     * @ORM\Column(name="estado_tiempo", type="string", nullable=true)
     */
    private $estadoTiempo;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgGeometria", inversedBy="geometrias")
     */
    private $geometria;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgUtilizacion", inversedBy="utilizaciones")
     */
    private $utilizacion;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgCalzadaCarril", inversedBy="calzadas")
     */
    private $calzada;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgCalzadaCarril", inversedBy="carriles")
     */
    private $carril;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgMaterial", inversedBy="materiales")
     */
    private $material;

      /**
     * @var string
     *
     * @ORM\Column(name="otro_material", type="string", nullable = true)
     */
    private $otroMaterial;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgEstadoVia", inversedBy="estadosvia")
     */
    private $estadoVia;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgCondicionVia", inversedBy="condicionesvia")
     */
    private $condicionVia;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgIluminacion", inversedBy="iuminaciones")
     */
    private $iluminacion;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgEstadoIluminacion", inversedBy="estadosiluminacion")
     */
    private $estadoIluminacion;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgVisual", inversedBy="visuales")
     */
    private $visual;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgVisualDisminuida", inversedBy="visualesdisminuidas")
     */
    private $visualDisminuida;

    /**
     * @var string
     *
     * @ORM\Column(name="otra_visualDisminuida", type="string", nullable = true)
     */
    private $otraVisualDisminuida;

    /**
     * @var bool
     *
     * @ORM\Column(name="hay_semaforo", type="boolean")
     */
    private $haySemaforo;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgControlVia", inversedBy="estadossemaforo")
     */
    private $estadoSemaforo;

    /**
     * @var string
     *
     * @ORM\Column(name="senial_vertical", type="string", nullable=true)
     */
    private $senialVertical;

    /**
     * @var string
     *
     * @ORM\Column(name="senial_horizontal", type="string", nullable=true)
     */
    private $senialHorizontal;

    /**
     * @var string
     *
     * @ORM\Column(name="reductor_velocidad", type="string", nullable=true)
     */
    private $reductorVelocidad;

    /**
     * @var string
     *
     * @ORM\Column(name="otro_reductor_velocidad", type="string", nullable=true)
     */
    private $otroReductorVelocidad;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgControlVia", inversedBy="delineadores_piso")
     */
    private $delineadorPiso;

    /**
     * @var string
     *
     * @ORM\Column(name="otro_delineador_piso", type="string", nullable=true)
     */
    private $otroDelineadorPiso;

    /**
     * @var bool
     *
     * @ORM\Column(name="mismo_conductor", type="boolean", nullable = true)
     */
    private $mismoConductor;

    /**
     * @var string
     *
     * @ORM\Column(name="nombres_propietario", type="string", nullable = true)
     */
    private $nombresPropietario;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos_propietario", type="string", nullable = true)
     */
    private $apellidosPropietario;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_identificacion_propietario", type="string", nullable = true)
     */
    private $tipoIdentificacionPropietario;

    /**
     * @var int
     *
     * @ORM\Column(name="identificacion_propietario", type="integer", nullable = true)
     */
    private $identificacionPropietario;
    
    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", nullable = true)
     */
    private $observaciones;
   
    /**
     * @var bool
     *
     * @ORM\Column(name="hay_testigo", type="boolean", nullable = true)
     */
    private $hayTestigo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nombres_testigo", type="string", nullable = true)
     */
    private $nombresTestigo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="apellidos_testigo", type="string", nullable = true)
     */
    private $apellidosTestigo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="tipo_identificacion_testigo", type="string", nullable = true)
     */
    private $tipoIdentificacionTestigo;

    /**
     * @var string
     *
     * @ORM\Column(name="identificacion_testigo", type="string", nullable = true)
     */
    private $identificacionTestigo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="direccion_residencia_testigo", type="string", nullable = true)
     */
    private $direccionResidenciaTestigo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="ciudad_residencia_testigo", type="string", nullable = true)
     */
    private $ciudadResidenciaTestigo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="telefono_testigo", type="string", nullable = true)
     */
    private $telefonoTestigo;


    //datos del agente de transito
    /**
     * @var string
     *
     * @ORM\Column(name="grado_agente", type="string", nullable = true)
     */
    private $gradoAgente;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nombres_agente", type="string", nullable = true)
     */
    private $nombresAgente;
    
    /**
     * @var string
     *
     * @ORM\Column(name="apellidos_agente", type="string", nullable = true)
     */
    private $apellidosAgente;
    
    /**
     * @var string
     *
     * @ORM\Column(name="tipo_identificacion_agente", type="string", nullable = true)
     */
    private $tipoIdentificacionAgente;

    /**
     * @var string
     *
     * @ORM\Column(name="identificacion_agente", type="string", nullable = true)
     */
    private $identificacionAgente;
    
    /**
     * @var string
     *
     * @ORM\Column(name="placa_agente", type="string", nullable = true)
     */
    private $placaAgente;
    
    /**
     * @var string
     *
     * @ORM\Column(name="entidad_agente", type="string", nullable = true)
     */
    private $entidadAgente;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgHipotesis", inversedBy="hipotesis")
     */
    private $hipotesis;
    
    /**
     * @var string
     *
     * @ORM\Column(name="total_peaton", type="string", nullable = true)
     */
    private $totalPeaton;
    
    /**
     * @var string
     *
     * @ORM\Column(name="total_acompaniante", type="string", nullable = true)
     */
    private $totalAcompaniante;
    
    /**
     * @var string
     *
     * @ORM\Column(name="total_pasajero", type="string", nullable = true)
     */
    private $totalPasajero;
    
    /**
     * @var string
     *
     * @ORM\Column(name="total_conductor", type="string", nullable = true)
     */
    private $totalConductor;
    
    /**
     * @var string
     *
     * @ORM\Column(name="total_herido", type="string", nullable = true)
     */
    private $totalHerido;

    /**
     * @var string
     *
     * @ORM\Column(name="total_muerto", type="string", nullable = true)
     */
    private $totalMuerto;


    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgMunicipio", inversedBy="municipios")
     */
    private $municipioCorrespondio;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgEntidadAccidente", inversedBy="entidadesaccidente")
     */
    private $entidadCorrespondio;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgUnidadReceptora", inversedBy="unidadesreceptoras")
     */
    private $unidadCorrespondio;

    /**
     * @var int
     *
     * @ORM\Column(name="anio_correspondio", type="integer", nullable = true)
     */
    private $anioCorrespondio;

    /**
     * @var int
     *
     * @ORM\Column(name="consecutivo_correspondio", type="integer", nullable = true)
     */
    private $consecutivoCorrespondio;

    /**
     * @var string
     *
     * @ORM\Column(name="correspondio", type="string", nullable = true)
     */
    private $correspondio;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

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
     * Set lugar
     *
     * @param string $lugar
     *
     * @return SvIpat
     */
    public function setLugar($lugar)
    {
        $this->lugar = $lugar;

        return $this;
    }

    /**
     * Get lugar
     *
     * @return string
     */
    public function getLugar()
    {
        return $this->lugar;
    }

    /**
     * Set fechaAccidente
     *
     * @param \DateTime $fechaAccidente
     *
     * @return SvIpat
     */
    public function setFechaAccidente($fechaAccidente)
    {
        $this->fechaAccidente = $fechaAccidente;

        return $this;
    }

    /**
     * Get fechaAccidente
     *
     * @return \DateTime
     */
    public function getFechaAccidente()
    {
        return $this->fechaAccidente;
    }

    /**
     * Set diaAccidente
     *
     * @param string $diaAccidente
     *
     * @return SvIpat
     */
    public function setDiaAccidente($diaAccidente)
    {
        $this->diaAccidente = $diaAccidente;

        return $this;
    }

    /**
     * Get diaAccidente
     *
     * @return string
     */
    public function getDiaAccidente()
    {
        return $this->diaAccidente;
    }

    /**
     * Set horaAccidente
     *
     * @param \DateTime $horaAccidente
     *
     * @return SvIpat
     */
    public function setHoraAccidente($horaAccidente)
    {
        $this->horaAccidente = $horaAccidente;

        return $this;
    }

    /**
     * Get horaAccidente
     *
     * @return \DateTime
     */
    public function getHoraAccidente()
    {
        return $this->horaAccidente;
    }

    /**
     * Set fechaLevantamiento
     *
     * @param \DateTime $fechaLevantamiento
     *
     * @return SvIpat
     */
    public function setFechaLevantamiento($fechaLevantamiento)
    {
        $this->fechaLevantamiento = $fechaLevantamiento;

        return $this;
    }

    /**
     * Get fechaLevantamiento
     *
     * @return \DateTime
     */
    public function getFechaLevantamiento()
    {
        return $this->fechaLevantamiento;
    }

    /**
     * Set horaLevantamiento
     *
     * @param \DateTime $horaLevantamiento
     *
     * @return SvIpat
     */
    public function setHoraLevantamiento($horaLevantamiento)
    {
        $this->horaLevantamiento = $horaLevantamiento;

        return $this;
    }

    /**
     * Get horaLevantamiento
     *
     * @return \DateTime
     */
    public function getHoraLevantamiento()
    {
        return $this->horaLevantamiento;
    }

    /**
     * Set otroClaseAccidente
     *
     * @param string $otroClaseAccidente
     *
     * @return SvIpat
     */
    public function setOtroClaseAccidente($otroClaseAccidente)
    {
        $this->otroClaseAccidente = $otroClaseAccidente;

        return $this;
    }

    /**
     * Get otroClaseAccidente
     *
     * @return string
     */
    public function getOtroClaseAccidente()
    {
        return $this->otroClaseAccidente;
    }

    /**
     * Set otroObjetoFijo
     *
     * @param string $otroObjetoFijo
     *
     * @return SvIpat
     */
    public function setOtroObjetoFijo($otroObjetoFijo)
    {
        $this->otroObjetoFijo = $otroObjetoFijo;

        return $this;
    }

    /**
     * Get otroObjetoFijo
     *
     * @return string
     */
    public function getOtroObjetoFijo()
    {
        return $this->otroObjetoFijo;
    }

    /**
     * Set estadoTiempo
     *
     * @param string $estadoTiempo
     *
     * @return SvIpat
     */
    public function setEstadoTiempo($estadoTiempo)
    {
        $this->estadoTiempo = $estadoTiempo;

        return $this;
    }

    /**
     * Get estadoTiempo
     *
     * @return string
     */
    public function getEstadoTiempo()
    {
        return $this->estadoTiempo;
    }

    /**
     * Set otroMaterial
     *
     * @param string $otroMaterial
     *
     * @return SvIpat
     */
    public function setOtroMaterial($otroMaterial)
    {
        $this->otroMaterial = $otroMaterial;

        return $this;
    }

    /**
     * Get otroMaterial
     *
     * @return string
     */
    public function getOtroMaterial()
    {
        return $this->otroMaterial;
    }

    /**
     * Set otraVisualDisminuida
     *
     * @param string $otraVisualDisminuida
     *
     * @return SvIpat
     */
    public function setOtraVisualDisminuida($otraVisualDisminuida)
    {
        $this->otraVisualDisminuida = $otraVisualDisminuida;

        return $this;
    }

    /**
     * Get otraVisualDisminuida
     *
     * @return string
     */
    public function getOtraVisualDisminuida()
    {
        return $this->otraVisualDisminuida;
    }

    /**
     * Set haySemaforo
     *
     * @param boolean $haySemaforo
     *
     * @return SvIpat
     */
    public function setHaySemaforo($haySemaforo)
    {
        $this->haySemaforo = $haySemaforo;

        return $this;
    }

    /**
     * Get haySemaforo
     *
     * @return boolean
     */
    public function getHaySemaforo()
    {
        return $this->haySemaforo;
    }

    /**
     * Set senialVertical
     *
     * @param string $senialVertical
     *
     * @return SvIpat
     */
    public function setSenialVertical($senialVertical)
    {
        $this->senialVertical = $senialVertical;

        return $this;
    }

    /**
     * Get senialVertical
     *
     * @return string
     */
    public function getSenialVertical()
    {
        return $this->senialVertical;
    }

    /**
     * Set senialHorizontal
     *
     * @param string $senialHorizontal
     *
     * @return SvIpat
     */
    public function setSenialHorizontal($senialHorizontal)
    {
        $this->senialHorizontal = $senialHorizontal;

        return $this;
    }

    /**
     * Get senialHorizontal
     *
     * @return string
     */
    public function getSenialHorizontal()
    {
        return $this->senialHorizontal;
    }

    /**
     * Set reductorVelocidad
     *
     * @param string $reductorVelocidad
     *
     * @return SvIpat
     */
    public function setReductorVelocidad($reductorVelocidad)
    {
        $this->reductorVelocidad = $reductorVelocidad;

        return $this;
    }

    /**
     * Get reductorVelocidad
     *
     * @return string
     */
    public function getReductorVelocidad()
    {
        return $this->reductorVelocidad;
    }

    /**
     * Set otroReductorVelocidad
     *
     * @param string $otroReductorVelocidad
     *
     * @return SvIpat
     */
    public function setOtroReductorVelocidad($otroReductorVelocidad)
    {
        $this->otroReductorVelocidad = $otroReductorVelocidad;

        return $this;
    }

    /**
     * Get otroReductorVelocidad
     *
     * @return string
     */
    public function getOtroReductorVelocidad()
    {
        return $this->otroReductorVelocidad;
    }

    /**
     * Set otroDelineadorPiso
     *
     * @param string $otroDelineadorPiso
     *
     * @return SvIpat
     */
    public function setOtroDelineadorPiso($otroDelineadorPiso)
    {
        $this->otroDelineadorPiso = $otroDelineadorPiso;

        return $this;
    }

    /**
     * Get otroDelineadorPiso
     *
     * @return string
     */
    public function getOtroDelineadorPiso()
    {
        return $this->otroDelineadorPiso;
    }

    /**
     * Set mismoConductor
     *
     * @param boolean $mismoConductor
     *
     * @return SvIpat
     */
    public function setMismoConductor($mismoConductor)
    {
        $this->mismoConductor = $mismoConductor;

        return $this;
    }

    /**
     * Get mismoConductor
     *
     * @return boolean
     */
    public function getMismoConductor()
    {
        return $this->mismoConductor;
    }

    /**
     * Set nombresPropietario
     *
     * @param string $nombresPropietario
     *
     * @return SvIpat
     */
    public function setNombresPropietario($nombresPropietario)
    {
        $this->nombresPropietario = $nombresPropietario;

        return $this;
    }

    /**
     * Get nombresPropietario
     *
     * @return string
     */
    public function getNombresPropietario()
    {
        return $this->nombresPropietario;
    }

    /**
     * Set apellidosPropietario
     *
     * @param string $apellidosPropietario
     *
     * @return SvIpat
     */
    public function setApellidosPropietario($apellidosPropietario)
    {
        $this->apellidosPropietario = $apellidosPropietario;

        return $this;
    }

    /**
     * Get apellidosPropietario
     *
     * @return string
     */
    public function getApellidosPropietario()
    {
        return $this->apellidosPropietario;
    }

    /**
     * Set tipoIdentificacionPropietario
     *
     * @param string $tipoIdentificacionPropietario
     *
     * @return SvIpat
     */
    public function setTipoIdentificacionPropietario($tipoIdentificacionPropietario)
    {
        $this->tipoIdentificacionPropietario = $tipoIdentificacionPropietario;

        return $this;
    }

    /**
     * Get tipoIdentificacionPropietario
     *
     * @return string
     */
    public function getTipoIdentificacionPropietario()
    {
        return $this->tipoIdentificacionPropietario;
    }

    /**
     * Set identificacionPropietario
     *
     * @param integer $identificacionPropietario
     *
     * @return SvIpat
     */
    public function setIdentificacionPropietario($identificacionPropietario)
    {
        $this->identificacionPropietario = $identificacionPropietario;

        return $this;
    }

    /**
     * Get identificacionPropietario
     *
     * @return integer
     */
    public function getIdentificacionPropietario()
    {
        return $this->identificacionPropietario;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return SvIpat
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set hayTestigo
     *
     * @param boolean $hayTestigo
     *
     * @return SvIpat
     */
    public function setHayTestigo($hayTestigo)
    {
        $this->hayTestigo = $hayTestigo;

        return $this;
    }

    /**
     * Get hayTestigo
     *
     * @return boolean
     */
    public function getHayTestigo()
    {
        return $this->hayTestigo;
    }

    /**
     * Set nombresTestigo
     *
     * @param string $nombresTestigo
     *
     * @return SvIpat
     */
    public function setNombresTestigo($nombresTestigo)
    {
        $this->nombresTestigo = $nombresTestigo;

        return $this;
    }

    /**
     * Get nombresTestigo
     *
     * @return string
     */
    public function getNombresTestigo()
    {
        return $this->nombresTestigo;
    }

    /**
     * Set apellidosTestigo
     *
     * @param string $apellidosTestigo
     *
     * @return SvIpat
     */
    public function setApellidosTestigo($apellidosTestigo)
    {
        $this->apellidosTestigo = $apellidosTestigo;

        return $this;
    }

    /**
     * Get apellidosTestigo
     *
     * @return string
     */
    public function getApellidosTestigo()
    {
        return $this->apellidosTestigo;
    }

    /**
     * Set tipoIdentificacionTestigo
     *
     * @param string $tipoIdentificacionTestigo
     *
     * @return SvIpat
     */
    public function setTipoIdentificacionTestigo($tipoIdentificacionTestigo)
    {
        $this->tipoIdentificacionTestigo = $tipoIdentificacionTestigo;

        return $this;
    }

    /**
     * Get tipoIdentificacionTestigo
     *
     * @return string
     */
    public function getTipoIdentificacionTestigo()
    {
        return $this->tipoIdentificacionTestigo;
    }

    /**
     * Set identificacionTestigo
     *
     * @param string $identificacionTestigo
     *
     * @return SvIpat
     */
    public function setIdentificacionTestigo($identificacionTestigo)
    {
        $this->identificacionTestigo = $identificacionTestigo;

        return $this;
    }

    /**
     * Get identificacionTestigo
     *
     * @return string
     */
    public function getIdentificacionTestigo()
    {
        return $this->identificacionTestigo;
    }

    /**
     * Set direccionResidenciaTestigo
     *
     * @param string $direccionResidenciaTestigo
     *
     * @return SvIpat
     */
    public function setDireccionResidenciaTestigo($direccionResidenciaTestigo)
    {
        $this->direccionResidenciaTestigo = $direccionResidenciaTestigo;

        return $this;
    }

    /**
     * Get direccionResidenciaTestigo
     *
     * @return string
     */
    public function getDireccionResidenciaTestigo()
    {
        return $this->direccionResidenciaTestigo;
    }

    /**
     * Set ciudadResidenciaTestigo
     *
     * @param string $ciudadResidenciaTestigo
     *
     * @return SvIpat
     */
    public function setCiudadResidenciaTestigo($ciudadResidenciaTestigo)
    {
        $this->ciudadResidenciaTestigo = $ciudadResidenciaTestigo;

        return $this;
    }

    /**
     * Get ciudadResidenciaTestigo
     *
     * @return string
     */
    public function getCiudadResidenciaTestigo()
    {
        return $this->ciudadResidenciaTestigo;
    }

    /**
     * Set telefonoTestigo
     *
     * @param string $telefonoTestigo
     *
     * @return SvIpat
     */
    public function setTelefonoTestigo($telefonoTestigo)
    {
        $this->telefonoTestigo = $telefonoTestigo;

        return $this;
    }

    /**
     * Get telefonoTestigo
     *
     * @return string
     */
    public function getTelefonoTestigo()
    {
        return $this->telefonoTestigo;
    }

    /**
     * Set gradoAgente
     *
     * @param string $gradoAgente
     *
     * @return SvIpat
     */
    public function setGradoAgente($gradoAgente)
    {
        $this->gradoAgente = $gradoAgente;

        return $this;
    }

    /**
     * Get gradoAgente
     *
     * @return string
     */
    public function getGradoAgente()
    {
        return $this->gradoAgente;
    }

    /**
     * Set nombresAgente
     *
     * @param string $nombresAgente
     *
     * @return SvIpat
     */
    public function setNombresAgente($nombresAgente)
    {
        $this->nombresAgente = $nombresAgente;

        return $this;
    }

    /**
     * Get nombresAgente
     *
     * @return string
     */
    public function getNombresAgente()
    {
        return $this->nombresAgente;
    }

    /**
     * Set apellidosAgente
     *
     * @param string $apellidosAgente
     *
     * @return SvIpat
     */
    public function setApellidosAgente($apellidosAgente)
    {
        $this->apellidosAgente = $apellidosAgente;

        return $this;
    }

    /**
     * Get apellidosAgente
     *
     * @return string
     */
    public function getApellidosAgente()
    {
        return $this->apellidosAgente;
    }

    /**
     * Set tipoIdentificacionAgente
     *
     * @param string $tipoIdentificacionAgente
     *
     * @return SvIpat
     */
    public function setTipoIdentificacionAgente($tipoIdentificacionAgente)
    {
        $this->tipoIdentificacionAgente = $tipoIdentificacionAgente;

        return $this;
    }

    /**
     * Get tipoIdentificacionAgente
     *
     * @return string
     */
    public function getTipoIdentificacionAgente()
    {
        return $this->tipoIdentificacionAgente;
    }

    /**
     * Set identificacionAgente
     *
     * @param string $identificacionAgente
     *
     * @return SvIpat
     */
    public function setIdentificacionAgente($identificacionAgente)
    {
        $this->identificacionAgente = $identificacionAgente;

        return $this;
    }

    /**
     * Get identificacionAgente
     *
     * @return string
     */
    public function getIdentificacionAgente()
    {
        return $this->identificacionAgente;
    }

    /**
     * Set placaAgente
     *
     * @param string $placaAgente
     *
     * @return SvIpat
     */
    public function setPlacaAgente($placaAgente)
    {
        $this->placaAgente = $placaAgente;

        return $this;
    }

    /**
     * Get placaAgente
     *
     * @return string
     */
    public function getPlacaAgente()
    {
        return $this->placaAgente;
    }

    /**
     * Set entidadAgente
     *
     * @param string $entidadAgente
     *
     * @return SvIpat
     */
    public function setEntidadAgente($entidadAgente)
    {
        $this->entidadAgente = $entidadAgente;

        return $this;
    }

    /**
     * Get entidadAgente
     *
     * @return string
     */
    public function getEntidadAgente()
    {
        return $this->entidadAgente;
    }

    /**
     * Set totalPeaton
     *
     * @param string $totalPeaton
     *
     * @return SvIpat
     */
    public function setTotalPeaton($totalPeaton)
    {
        $this->totalPeaton = $totalPeaton;

        return $this;
    }

    /**
     * Get totalPeaton
     *
     * @return string
     */
    public function getTotalPeaton()
    {
        return $this->totalPeaton;
    }

    /**
     * Set totalAcompaniante
     *
     * @param string $totalAcompaniante
     *
     * @return SvIpat
     */
    public function setTotalAcompaniante($totalAcompaniante)
    {
        $this->totalAcompaniante = $totalAcompaniante;

        return $this;
    }

    /**
     * Get totalAcompaniante
     *
     * @return string
     */
    public function getTotalAcompaniante()
    {
        return $this->totalAcompaniante;
    }

    /**
     * Set totalPasajero
     *
     * @param string $totalPasajero
     *
     * @return SvIpat
     */
    public function setTotalPasajero($totalPasajero)
    {
        $this->totalPasajero = $totalPasajero;

        return $this;
    }

    /**
     * Get totalPasajero
     *
     * @return string
     */
    public function getTotalPasajero()
    {
        return $this->totalPasajero;
    }

    /**
     * Set totalConductor
     *
     * @param string $totalConductor
     *
     * @return SvIpat
     */
    public function setTotalConductor($totalConductor)
    {
        $this->totalConductor = $totalConductor;

        return $this;
    }

    /**
     * Get totalConductor
     *
     * @return string
     */
    public function getTotalConductor()
    {
        return $this->totalConductor;
    }

    /**
     * Set totalHerido
     *
     * @param string $totalHerido
     *
     * @return SvIpat
     */
    public function setTotalHerido($totalHerido)
    {
        $this->totalHerido = $totalHerido;

        return $this;
    }

    /**
     * Get totalHerido
     *
     * @return string
     */
    public function getTotalHerido()
    {
        return $this->totalHerido;
    }

    /**
     * Set totalMuerto
     *
     * @param string $totalMuerto
     *
     * @return SvIpat
     */
    public function setTotalMuerto($totalMuerto)
    {
        $this->totalMuerto = $totalMuerto;

        return $this;
    }

    /**
     * Get totalMuerto
     *
     * @return string
     */
    public function getTotalMuerto()
    {
        return $this->totalMuerto;
    }

    /**
     * Set anioCorrespondio
     *
     * @param integer $anioCorrespondio
     *
     * @return SvIpat
     */
    public function setAnioCorrespondio($anioCorrespondio)
    {
        $this->anioCorrespondio = $anioCorrespondio;

        return $this;
    }

    /**
     * Get anioCorrespondio
     *
     * @return integer
     */
    public function getAnioCorrespondio()
    {
        return $this->anioCorrespondio;
    }

    /**
     * Set consecutivoCorrespondio
     *
     * @param integer $consecutivoCorrespondio
     *
     * @return SvIpat
     */
    public function setConsecutivoCorrespondio($consecutivoCorrespondio)
    {
        $this->consecutivoCorrespondio = $consecutivoCorrespondio;

        return $this;
    }

    /**
     * Get consecutivoCorrespondio
     *
     * @return integer
     */
    public function getConsecutivoCorrespondio()
    {
        return $this->consecutivoCorrespondio;
    }

    /**
     * Set correspondio
     *
     * @param string $correspondio
     *
     * @return SvIpat
     */
    public function setCorrespondio($correspondio)
    {
        $this->correspondio = $correspondio;

        return $this;
    }

    /**
     * Get correspondio
     *
     * @return string
     */
    public function getCorrespondio()
    {
        return $this->correspondio;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return SvIpat
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
     * Set consecutivo
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvIpatConsecutivo $consecutivo
     *
     * @return SvIpat
     */
    public function setConsecutivo(\JHWEB\SeguridadVialBundle\Entity\SvIpatConsecutivo $consecutivo = null)
    {
        $this->consecutivo = $consecutivo;

        return $this;
    }

    /**
     * Get consecutivo
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvIpatConsecutivo
     */
    public function getConsecutivo()
    {
        return $this->consecutivo;
    }

    /**
     * Set gravedadAccidente
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgGravedadAccidente $gravedadAccidente
     *
     * @return SvIpat
     */
    public function setGravedadAccidente(\JHWEB\SeguridadVialBundle\Entity\SvCfgGravedadAccidente $gravedadAccidente = null)
    {
        $this->gravedadAccidente = $gravedadAccidente;

        return $this;
    }

    /**
     * Get gravedadAccidente
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgGravedadAccidente
     */
    public function getGravedadAccidente()
    {
        return $this->gravedadAccidente;
    }

    /**
     * Set claseAccidente
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgClaseAccidente $claseAccidente
     *
     * @return SvIpat
     */
    public function setClaseAccidente(\JHWEB\SeguridadVialBundle\Entity\SvCfgClaseAccidente $claseAccidente = null)
    {
        $this->claseAccidente = $claseAccidente;

        return $this;
    }

    /**
     * Get claseAccidente
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgClaseAccidente
     */
    public function getClaseAccidente()
    {
        return $this->claseAccidente;
    }

    /**
     * Set claseChoque
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgClaseChoque $claseChoque
     *
     * @return SvIpat
     */
    public function setClaseChoque(\JHWEB\SeguridadVialBundle\Entity\SvCfgClaseChoque $claseChoque = null)
    {
        $this->claseChoque = $claseChoque;

        return $this;
    }

    /**
     * Get claseChoque
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgClaseChoque
     */
    public function getClaseChoque()
    {
        return $this->claseChoque;
    }

    /**
     * Set objetoFijo
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgObjetoFijo $objetoFijo
     *
     * @return SvIpat
     */
    public function setObjetoFijo(\JHWEB\SeguridadVialBundle\Entity\SvCfgObjetoFijo $objetoFijo = null)
    {
        $this->objetoFijo = $objetoFijo;

        return $this;
    }

    /**
     * Get objetoFijo
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgObjetoFijo
     */
    public function getObjetoFijo()
    {
        return $this->objetoFijo;
    }

    /**
     * Set area
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgArea $area
     *
     * @return SvIpat
     */
    public function setArea(\JHWEB\SeguridadVialBundle\Entity\SvCfgArea $area = null)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgArea
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Set tipoArea
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgTipoArea $tipoArea
     *
     * @return SvIpat
     */
    public function setTipoArea(\JHWEB\SeguridadVialBundle\Entity\SvCfgTipoArea $tipoArea = null)
    {
        $this->tipoArea = $tipoArea;

        return $this;
    }

    /**
     * Get tipoArea
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgTipoArea
     */
    public function getTipoArea()
    {
        return $this->tipoArea;
    }

    /**
     * Set tipoVia
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgTipoVia $tipoVia
     *
     * @return SvIpat
     */
    public function setTipoVia(\JHWEB\SeguridadVialBundle\Entity\SvCfgTipoVia $tipoVia = null)
    {
        $this->tipoVia = $tipoVia;

        return $this;
    }

    /**
     * Get tipoVia
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgTipoVia
     */
    public function getTipoVia()
    {
        return $this->tipoVia;
    }

    /**
     * Set cardinalidad
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgCardinalidad $cardinalidad
     *
     * @return SvIpat
     */
    public function setCardinalidad(\JHWEB\SeguridadVialBundle\Entity\SvCfgCardinalidad $cardinalidad = null)
    {
        $this->cardinalidad = $cardinalidad;

        return $this;
    }

    /**
     * Get cardinalidad
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgCardinalidad
     */
    public function getCardinalidad()
    {
        return $this->cardinalidad;
    }

    /**
     * Set sector
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgSector $sector
     *
     * @return SvIpat
     */
    public function setSector(\JHWEB\SeguridadVialBundle\Entity\SvCfgSector $sector = null)
    {
        $this->sector = $sector;

        return $this;
    }

    /**
     * Get sector
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgSector
     */
    public function getSector()
    {
        return $this->sector;
    }

    /**
     * Set zona
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgZona $zona
     *
     * @return SvIpat
     */
    public function setZona(\JHWEB\SeguridadVialBundle\Entity\SvCfgZona $zona = null)
    {
        $this->zona = $zona;

        return $this;
    }

    /**
     * Get zona
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgZona
     */
    public function getZona()
    {
        return $this->zona;
    }

    /**
     * Set disenio
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgDisenio $disenio
     *
     * @return SvIpat
     */
    public function setDisenio(\JHWEB\SeguridadVialBundle\Entity\SvCfgDisenio $disenio = null)
    {
        $this->disenio = $disenio;

        return $this;
    }

    /**
     * Get disenio
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgDisenio
     */
    public function getDisenio()
    {
        return $this->disenio;
    }

    /**
     * Set geometria
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgGeometria $geometria
     *
     * @return SvIpat
     */
    public function setGeometria(\JHWEB\SeguridadVialBundle\Entity\SvCfgGeometria $geometria = null)
    {
        $this->geometria = $geometria;

        return $this;
    }

    /**
     * Get geometria
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgGeometria
     */
    public function getGeometria()
    {
        return $this->geometria;
    }

    /**
     * Set utilizacion
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgUtilizacion $utilizacion
     *
     * @return SvIpat
     */
    public function setUtilizacion(\JHWEB\SeguridadVialBundle\Entity\SvCfgUtilizacion $utilizacion = null)
    {
        $this->utilizacion = $utilizacion;

        return $this;
    }

    /**
     * Get utilizacion
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgUtilizacion
     */
    public function getUtilizacion()
    {
        return $this->utilizacion;
    }

    /**
     * Set calzada
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgCalzadaCarril $calzada
     *
     * @return SvIpat
     */
    public function setCalzada(\JHWEB\SeguridadVialBundle\Entity\SvCfgCalzadaCarril $calzada = null)
    {
        $this->calzada = $calzada;

        return $this;
    }

    /**
     * Get calzada
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgCalzadaCarril
     */
    public function getCalzada()
    {
        return $this->calzada;
    }

    /**
     * Set carril
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgCalzadaCarril $carril
     *
     * @return SvIpat
     */
    public function setCarril(\JHWEB\SeguridadVialBundle\Entity\SvCfgCalzadaCarril $carril = null)
    {
        $this->carril = $carril;

        return $this;
    }

    /**
     * Get carril
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgCalzadaCarril
     */
    public function getCarril()
    {
        return $this->carril;
    }

    /**
     * Set material
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgMaterial $material
     *
     * @return SvIpat
     */
    public function setMaterial(\JHWEB\SeguridadVialBundle\Entity\SvCfgMaterial $material = null)
    {
        $this->material = $material;

        return $this;
    }

    /**
     * Get material
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgMaterial
     */
    public function getMaterial()
    {
        return $this->material;
    }

    /**
     * Set estadoVia
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgEstadoVia $estadoVia
     *
     * @return SvIpat
     */
    public function setEstadoVia(\JHWEB\SeguridadVialBundle\Entity\SvCfgEstadoVia $estadoVia = null)
    {
        $this->estadoVia = $estadoVia;

        return $this;
    }

    /**
     * Get estadoVia
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgEstadoVia
     */
    public function getEstadoVia()
    {
        return $this->estadoVia;
    }

    /**
     * Set condicionVia
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgCondicionVia $condicionVia
     *
     * @return SvIpat
     */
    public function setCondicionVia(\JHWEB\SeguridadVialBundle\Entity\SvCfgCondicionVia $condicionVia = null)
    {
        $this->condicionVia = $condicionVia;

        return $this;
    }

    /**
     * Get condicionVia
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgCondicionVia
     */
    public function getCondicionVia()
    {
        return $this->condicionVia;
    }

    /**
     * Set iluminacion
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgIluminacion $iluminacion
     *
     * @return SvIpat
     */
    public function setIluminacion(\JHWEB\SeguridadVialBundle\Entity\SvCfgIluminacion $iluminacion = null)
    {
        $this->iluminacion = $iluminacion;

        return $this;
    }

    /**
     * Get iluminacion
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgIluminacion
     */
    public function getIluminacion()
    {
        return $this->iluminacion;
    }

    /**
     * Set estadoIluminacion
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgEstadoIluminacion $estadoIluminacion
     *
     * @return SvIpat
     */
    public function setEstadoIluminacion(\JHWEB\SeguridadVialBundle\Entity\SvCfgEstadoIluminacion $estadoIluminacion = null)
    {
        $this->estadoIluminacion = $estadoIluminacion;

        return $this;
    }

    /**
     * Get estadoIluminacion
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgEstadoIluminacion
     */
    public function getEstadoIluminacion()
    {
        return $this->estadoIluminacion;
    }

    /**
     * Set visual
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgVisual $visual
     *
     * @return SvIpat
     */
    public function setVisual(\JHWEB\SeguridadVialBundle\Entity\SvCfgVisual $visual = null)
    {
        $this->visual = $visual;

        return $this;
    }

    /**
     * Get visual
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgVisual
     */
    public function getVisual()
    {
        return $this->visual;
    }

    /**
     * Set visualDisminuida
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgVisualDisminuida $visualDisminuida
     *
     * @return SvIpat
     */
    public function setVisualDisminuida(\JHWEB\SeguridadVialBundle\Entity\SvCfgVisualDisminuida $visualDisminuida = null)
    {
        $this->visualDisminuida = $visualDisminuida;

        return $this;
    }

    /**
     * Get visualDisminuida
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgVisualDisminuida
     */
    public function getVisualDisminuida()
    {
        return $this->visualDisminuida;
    }

    /**
     * Set estadoSemaforo
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgControlVia $estadoSemaforo
     *
     * @return SvIpat
     */
    public function setEstadoSemaforo(\JHWEB\SeguridadVialBundle\Entity\SvCfgControlVia $estadoSemaforo = null)
    {
        $this->estadoSemaforo = $estadoSemaforo;

        return $this;
    }

    /**
     * Get estadoSemaforo
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgControlVia
     */
    public function getEstadoSemaforo()
    {
        return $this->estadoSemaforo;
    }

    /**
     * Set delineadorPiso
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgControlVia $delineadorPiso
     *
     * @return SvIpat
     */
    public function setDelineadorPiso(\JHWEB\SeguridadVialBundle\Entity\SvCfgControlVia $delineadorPiso = null)
    {
        $this->delineadorPiso = $delineadorPiso;

        return $this;
    }

    /**
     * Get delineadorPiso
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgControlVia
     */
    public function getDelineadorPiso()
    {
        return $this->delineadorPiso;
    }

    /**
     * Set hipotesis
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgHipotesis $hipotesis
     *
     * @return SvIpat
     */
    public function setHipotesis(\JHWEB\SeguridadVialBundle\Entity\SvCfgHipotesis $hipotesis = null)
    {
        $this->hipotesis = $hipotesis;

        return $this;
    }

    /**
     * Get hipotesis
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgHipotesis
     */
    public function getHipotesis()
    {
        return $this->hipotesis;
    }

    /**
     * Set municipioCorrespondio
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgMunicipio $municipioCorrespondio
     *
     * @return SvIpat
     */
    public function setMunicipioCorrespondio(\JHWEB\ConfigBundle\Entity\CfgMunicipio $municipioCorrespondio = null)
    {
        $this->municipioCorrespondio = $municipioCorrespondio;

        return $this;
    }

    /**
     * Get municipioCorrespondio
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgMunicipio
     */
    public function getMunicipioCorrespondio()
    {
        return $this->municipioCorrespondio;
    }

    /**
     * Set entidadCorrespondio
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgEntidadAccidente $entidadCorrespondio
     *
     * @return SvIpat
     */
    public function setEntidadCorrespondio(\JHWEB\SeguridadVialBundle\Entity\SvCfgEntidadAccidente $entidadCorrespondio = null)
    {
        $this->entidadCorrespondio = $entidadCorrespondio;

        return $this;
    }

    /**
     * Get entidadCorrespondio
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgEntidadAccidente
     */
    public function getEntidadCorrespondio()
    {
        return $this->entidadCorrespondio;
    }

    /**
     * Set unidadCorrespondio
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgUnidadReceptora $unidadCorrespondio
     *
     * @return SvIpat
     */
    public function setUnidadCorrespondio(\JHWEB\SeguridadVialBundle\Entity\SvCfgUnidadReceptora $unidadCorrespondio = null)
    {
        $this->unidadCorrespondio = $unidadCorrespondio;

        return $this;
    }

    /**
     * Get unidadCorrespondio
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgUnidadReceptora
     */
    public function getUnidadCorrespondio()
    {
        return $this->unidadCorrespondio;
    }
}
