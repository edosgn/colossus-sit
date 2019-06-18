<?php

namespace JHWEB\UsuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserEmpresaTransporte
 *
 * @ORM\Table(name="user_empresa_transporte")
 * @ORM\Entity(repositoryClass="JHWEB\UsuarioBundle\Repository\UserEmpresaTransporteRepository")
 */
class UserEmpresaTransporte
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /** @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserEmpresa", inversedBy="representanteEmpresa") */
    private $empresa;
    
    /** @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloCfgRadioAccion", inversedBy="empresaTransporte") */
    private $radioAccion;
    
    /** @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloCfgModalidadTransporte", inversedBy="empresaTransporte") */
    private $modalidadTransporte;
    
    /** @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloCfgServicio", inversedBy="empresaTransporte") */
    private $servicio;
    
    /** @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloCfgClase", inversedBy="empresaTransporte") */
    private $clase;

    /**
     * @var int
     *
     * @ORM\Column(name="numero_acto", type="bigint")
     */
    private $numeroActo;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_expedicion", type="date")
     */
    private $fechaExpedicionActo;

    /**
     * @var int
     *
     * @ORM\Column(name="numero_ejecutoria_acto", type="bigint")
     */
    private $numeroEjecutoriaActo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_ejecutoria_acto", type="date")
     */
    private $fechaEjecutoriaActo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="colores", type="string")
     */
    private $colores;
    
    /**
     * @var string
     *
     * @ORM\Column(name="municipios", type="string")
     */
    private $municipios;

    /** @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloCfgCarroceria", inversedBy="empresaTransporte") */
    private $carroceria;
    
    /**
     * @var int
     *
     * @ORM\Column(name="capacidad", type="bigint", nullable=true)
     */
    private $capacidad;
    
    /**
     * @var int
     *
     * @ORM\Column(name="capacidad_minima", type="bigint", nullable=true)
     */
    private $capacidadMinima;
    
    /**
     * @var int
     *
     * @ORM\Column(name="capacidad_maxima", type="bigint", nullable=true)
     */
    private $capacidadMaxima;
    
    
    /**
     * @var int
     *
     * @ORM\Column(name="rango_inicio", type="bigint", nullable=true)
     */
    private $rangoInicio;
    
    /**
     * @var int
     *
     * @ORM\Column(name="rango_fin", type="bigint", nullable=true)
     */
    private $rangoFin;
    
    /**
     * @var int
     *
     * @ORM\Column(name="numero_resolucion_cupo", type="bigint", nullable=true)
     */
    private $numeroResolucionCupo;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_resolucion_cupo", type="date", nullable=true)
     */
    private $fechaResolucionCupo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", nullable=true)
     */
    private $observaciones;

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
     * Set numeroActo
     *
     * @param integer $numeroActo
     *
     * @return UserEmpresaTransporte
     */
    public function setNumeroActo($numeroActo)
    {
        $this->numeroActo = $numeroActo;

        return $this;
    }

    /**
     * Get numeroActo
     *
     * @return integer
     */
    public function getNumeroActo()
    {
        return $this->numeroActo;
    }

    /**
     * Set fechaExpedicionActo
     *
     * @param \DateTime $fechaExpedicionActo
     *
     * @return UserEmpresaTransporte
     */
    public function setFechaExpedicionActo($fechaExpedicionActo)
    {
        $this->fechaExpedicionActo = $fechaExpedicionActo;

        return $this;
    }

    /**
     * Get fechaExpedicionActo
     *
     * @return \DateTime
     */
    public function getFechaExpedicionActo()
    {
        return $this->fechaExpedicionActo;
    }

    /**
     * Set numeroEjecutoriaActo
     *
     * @param integer $numeroEjecutoriaActo
     *
     * @return UserEmpresaTransporte
     */
    public function setNumeroEjecutoriaActo($numeroEjecutoriaActo)
    {
        $this->numeroEjecutoriaActo = $numeroEjecutoriaActo;

        return $this;
    }

    /**
     * Get numeroEjecutoriaActo
     *
     * @return integer
     */
    public function getNumeroEjecutoriaActo()
    {
        return $this->numeroEjecutoriaActo;
    }

    /**
     * Set fechaEjecutoriaActo
     *
     * @param \DateTime $fechaEjecutoriaActo
     *
     * @return UserEmpresaTransporte
     */
    public function setFechaEjecutoriaActo($fechaEjecutoriaActo)
    {
        $this->fechaEjecutoriaActo = $fechaEjecutoriaActo;

        return $this;
    }

    /**
     * Get fechaEjecutoriaActo
     *
     * @return \DateTime
     */
    public function getFechaEjecutoriaActo()
    {
        return $this->fechaEjecutoriaActo;
    }

    /**
     * Set colores
     *
     * @param string $colores
     *
     * @return UserEmpresaTransporte
     */
    public function setColores($colores)
    {
        $this->colores = $colores;

        return $this;
    }

    /**
     * Get colores
     *
     * @return string
     */
    public function getColores()
    {
        return $this->colores;
    }

    /**
     * Set municipios
     *
     * @param string $municipios
     *
     * @return UserEmpresaTransporte
     */
    public function setMunicipios($municipios)
    {
        $this->municipios = $municipios;

        return $this;
    }

    /**
     * Get municipios
     *
     * @return string
     */
    public function getMunicipios()
    {
        return $this->municipios;
    }

    /**
     * Set capacidad
     *
     * @param integer $capacidad
     *
     * @return UserEmpresaTransporte
     */
    public function setCapacidad($capacidad)
    {
        $this->capacidad = $capacidad;

        return $this;
    }

    /**
     * Get capacidad
     *
     * @return integer
     */
    public function getCapacidad()
    {
        return $this->capacidad;
    }

    /**
     * Set capacidadMinima
     *
     * @param integer $capacidadMinima
     *
     * @return UserEmpresaTransporte
     */
    public function setCapacidadMinima($capacidadMinima)
    {
        $this->capacidadMinima = $capacidadMinima;

        return $this;
    }

    /**
     * Get capacidadMinima
     *
     * @return integer
     */
    public function getCapacidadMinima()
    {
        return $this->capacidadMinima;
    }

    /**
     * Set capacidadMaxima
     *
     * @param integer $capacidadMaxima
     *
     * @return UserEmpresaTransporte
     */
    public function setCapacidadMaxima($capacidadMaxima)
    {
        $this->capacidadMaxima = $capacidadMaxima;

        return $this;
    }

    /**
     * Get capacidadMaxima
     *
     * @return integer
     */
    public function getCapacidadMaxima()
    {
        return $this->capacidadMaxima;
    }

    /**
     * Set rangoInicio
     *
     * @param integer $rangoInicio
     *
     * @return UserEmpresaTransporte
     */
    public function setRangoInicio($rangoInicio)
    {
        $this->rangoInicio = $rangoInicio;

        return $this;
    }

    /**
     * Get rangoInicio
     *
     * @return integer
     */
    public function getRangoInicio()
    {
        return $this->rangoInicio;
    }

    /**
     * Set rangoFin
     *
     * @param integer $rangoFin
     *
     * @return UserEmpresaTransporte
     */
    public function setRangoFin($rangoFin)
    {
        $this->rangoFin = $rangoFin;

        return $this;
    }

    /**
     * Get rangoFin
     *
     * @return integer
     */
    public function getRangoFin()
    {
        return $this->rangoFin;
    }

    /**
     * Set numeroResolucionCupo
     *
     * @param integer $numeroResolucionCupo
     *
     * @return UserEmpresaTransporte
     */
    public function setNumeroResolucionCupo($numeroResolucionCupo)
    {
        $this->numeroResolucionCupo = $numeroResolucionCupo;

        return $this;
    }

    /**
     * Get numeroResolucionCupo
     *
     * @return integer
     */
    public function getNumeroResolucionCupo()
    {
        return $this->numeroResolucionCupo;
    }

    /**
     * Set fechaResolucionCupo
     *
     * @param \DateTime $fechaResolucionCupo
     *
     * @return UserEmpresaTransporte
     */
    public function setFechaResolucionCupo($fechaResolucionCupo)
    {
        $this->fechaResolucionCupo = $fechaResolucionCupo;

        return $this;
    }

    /**
     * Get fechaResolucionCupo
     *
     * @return \DateTime
     */
    public function getFechaResolucionCupo()
    {
        return $this->fechaResolucionCupo;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return UserEmpresaTransporte
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return UserEmpresaTransporte
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
     * @return UserEmpresaTransporte
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
     * Set radioAccion
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgRadioAccion $radioAccion
     *
     * @return UserEmpresaTransporte
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
     * @return UserEmpresaTransporte
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
     * Set servicio
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgServicio $servicio
     *
     * @return UserEmpresaTransporte
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
     * @return UserEmpresaTransporte
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
     * Set carroceria
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgCarroceria $carroceria
     *
     * @return UserEmpresaTransporte
     */
    public function setCarroceria(\JHWEB\VehiculoBundle\Entity\VhloCfgCarroceria $carroceria = null)
    {
        $this->carroceria = $carroceria;

        return $this;
    }

    /**
     * Get carroceria
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgCarroceria
     */
    public function getCarroceria()
    {
        return $this->carroceria;
    }
}
