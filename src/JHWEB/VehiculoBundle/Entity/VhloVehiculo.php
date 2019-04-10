<?php

namespace JHWEB\VehiculoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VhloVehiculo
 *
 * @ORM\Table(name="vhlo_vehiculo")
 * @ORM\Entity(repositoryClass="JHWEB\VehiculoBundle\Repository\VhloVehiculoRepository")
 */
class VhloVehiculo
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
     * @var int
     *
     * @ORM\Column(name="numero_factura", type="integer", nullable= true)
     */
    private $numeroFactura;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_factura", type="datetime", nullable= true)
     */
    private $fechaFactura;

    /**
     * @var string
     *
     * @ORM\Column(name="valor", type="string", length=255, nullable= true)
     */
    private $valor;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_manifiesto", type="string", length=255, nullable= true)
     */
    private $numeroManifiesto;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_manifiesto", type="datetime", nullable= true)
     */
    private $fechaManifiesto;

    /**
     * @var string
     *
     * @ORM\Column(name="cilindraje", type="string", length=255, nullable= true)
     */
    private $cilindraje;

    /**
     * @var int
     *
     * @ORM\Column(name="modelo", type="integer", nullable= true)
     */
    private $modelo;

    /**
     * @var string
     *
     * @ORM\Column(name="motor",type="string", length=255, nullable= true)
     */
    private $motor;

    /**
     * @var string
     *
     * @ORM\Column(name="chasis", type="string", length=255, nullable= true)
     */
    private $chasis;

    /**
     * @var string
     *
     * @ORM\Column(name="serie", type="string", length=255, nullable= true)
     */
    private $serie;

    /**
     * @var string
     *
     * @ORM\Column(name="vin", type="string", length=255, nullable= true)
     */
    private $vin;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_matricula", type="string", length=255, nullable= true)
     */
    private $tipoMatricula;
  
    /**
     * @var int
     *
     * @ORM\Column(name="numero_pasajeros", type="integer", nullable= true)
     */
    private $numeroPasajeros;

    /**
     * @var int
     *
     * @ORM\Column(name="capacidad_carga", type="integer", nullable= true)
     */
    private $capacidadCarga;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_blindaje", type="string", length=255, nullable= true)
     */
    private $tipoBlindaje;

    /**
     * @var string
     *
     * @ORM\Column(name="nivel_blindaje", type="string", length=255, nullable= true)
     */
    private $nivelBlindaje;

    /**
     * @var string
     *
     * @ORM\Column(name="empresa_blindadora", type="string", length=255, nullable= true)
     */
    private $empresaBlindadora;

    /**
     * @var boolean
     *
     * @ORM\Column(name="pignorado", type="boolean", nullable= true)
     */
    private $pignorado;

    /**
     * @var boolean
     *
     * @ORM\Column(name="cancelado", type="boolean", nullable= true)
     */
    private $cancelado;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /** @ORM\ManyToOne(targetEntity="VhloCfgLinea", inversedBy="vehiculos") */
    private $linea;

    /** @ORM\ManyToOne(targetEntity="VhloCfgServicio", inversedBy="vehiculos") */
    private $servicio; 

    /** @ORM\ManyToOne(targetEntity="VhloCfgColor", inversedBy="vehiculos") */
    private $color;

    /** @ORM\ManyToOne(targetEntity="VhloCfgCombustible", inversedBy="vehiculos") */
    private $combustible; 

    /** @ORM\ManyToOne(targetEntity="VhloCfgCarroceria", inversedBy="vehiculos") */
    private $carroceria;

    /** @ORM\ManyToOne(targetEntity="VhloCfgClase", inversedBy="vehiculos") */
    private $clase;

    /** @ORM\ManyToOne(targetEntity="VhloCfgRadioAccion", inversedBy="vehiculos") */
    private $radioAccion;

    /** @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloCfgModalidadTransporte", inversedBy="vehiculos") */
    private $modalidadTransporte;

    /** @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgNacionalidad", inversedBy="nacionalidades") */
    private $nacionalidad;

    /** @ORM\ManyToOne(targetEntity="VhloCfgPlaca", inversedBy="vehiculos") */
    private $placa;

    /** @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgPais", inversedBy="paises") */
    private $pais; 

    /** @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgMunicipio", inversedBy="vehiculos") */
    private $municipio; 

    /** @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgOrganismoTransito", inversedBy="vehiculos") */
    private $organismoTransito;

    /** @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserEmpresa", inversedBy="vehiculos") */
    private $empresa;


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
     * Set numeroFactura
     *
     * @param integer $numeroFactura
     *
     * @return VhloVehiculo
     */
    public function setNumeroFactura($numeroFactura)
    {
        $this->numeroFactura = $numeroFactura;

        return $this;
    }

    /**
     * Get numeroFactura
     *
     * @return integer
     */
    public function getNumeroFactura()
    {
        return $this->numeroFactura;
    }

    /**
     * Set fechaFactura
     *
     * @param \DateTime $fechaFactura
     *
     * @return VhloVehiculo
     */
    public function setFechaFactura($fechaFactura)
    {
        $this->fechaFactura = $fechaFactura;

        return $this;
    }

    /**
     * Get fechaFactura
     *
     * @return \DateTime
     */
    public function getFechaFactura()
    {
        if($this->fechaFactura){
            return $this->fechaFactura->format('d/m/Y');
        }
        return $this->fechaFactura;
    }

    /**
     * Set valor
     *
     * @param string $valor
     *
     * @return VhloVehiculo
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set numeroManifiesto
     *
     * @param string $numeroManifiesto
     *
     * @return VhloVehiculo
     */
    public function setNumeroManifiesto($numeroManifiesto)
    {
        $this->numeroManifiesto = $numeroManifiesto;

        return $this;
    }

    /**
     * Get numeroManifiesto
     *
     * @return string
     */
    public function getNumeroManifiesto()
    {
        return $this->numeroManifiesto;
    }

    /**
     * Set fechaManifiesto
     *
     * @param \DateTime $fechaManifiesto
     *
     * @return VhloVehiculo
     */
    public function setFechaManifiesto($fechaManifiesto)
    {
        $this->fechaManifiesto = $fechaManifiesto;

        return $this;
    }

    /**
     * Get fechaManifiesto
     *
     * @return \DateTime
     */
    public function getFechaManifiesto()
    {
        if($this->fechaManifiesto){
            return $this->fechaManifiesto->format('d/m/Y');
        }
        return $this->fechaManifiesto;
    }

    /**
     * Set cilindraje
     *
     * @param string $cilindraje
     *
     * @return VhloVehiculo
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
     * Set modelo
     *
     * @param integer $modelo
     *
     * @return VhloVehiculo
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get modelo
     *
     * @return integer
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * Set motor
     *
     * @param string $motor
     *
     * @return VhloVehiculo
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
     * Set chasis
     *
     * @param string $chasis
     *
     * @return VhloVehiculo
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
     * Set serie
     *
     * @param string $serie
     *
     * @return VhloVehiculo
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;

        return $this;
    }

    /**
     * Get serie
     *
     * @return string
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Set vin
     *
     * @param string $vin
     *
     * @return VhloVehiculo
     */
    public function setVin($vin)
    {
        $this->vin = $vin;

        return $this;
    }

    /**
     * Get vin
     *
     * @return string
     */
    public function getVin()
    {
        return $this->vin;
    }

    /**
     * Set tipoMatricula
     *
     * @param string $tipoMatricula
     *
     * @return VhloVehiculo
     */
    public function setTipoMatricula($tipoMatricula)
    {
        $this->tipoMatricula = $tipoMatricula;

        return $this;
    }

    /**
     * Get tipoMatricula
     *
     * @return string
     */
    public function getTipoMatricula()
    {
        return $this->tipoMatricula;
    }

    /**
     * Set numeroPasajeros
     *
     * @param integer $numeroPasajeros
     *
     * @return VhloVehiculo
     */
    public function setNumeroPasajeros($numeroPasajeros)
    {
        $this->numeroPasajeros = $numeroPasajeros;

        return $this;
    }

    /**
     * Get numeroPasajeros
     *
     * @return integer
     */
    public function getNumeroPasajeros()
    {
        return $this->numeroPasajeros;
    }

    /**
     * Set capacidadCarga
     *
     * @param integer $capacidadCarga
     *
     * @return VhloVehiculo
     */
    public function setCapacidadCarga($capacidadCarga)
    {
        $this->capacidadCarga = $capacidadCarga;

        return $this;
    }

    /**
     * Get capacidadCarga
     *
     * @return integer
     */
    public function getCapacidadCarga()
    {
        return $this->capacidadCarga;
    }

    /**
     * Set tipoBlindaje
     *
     * @param string $tipoBlindaje
     *
     * @return VhloVehiculo
     */
    public function setTipoBlindaje($tipoBlindaje)
    {
        $this->tipoBlindaje = $tipoBlindaje;

        return $this;
    }

    /**
     * Get tipoBlindaje
     *
     * @return string
     */
    public function getTipoBlindaje()
    {
        return $this->tipoBlindaje;
    }

    /**
     * Set nivelBlindaje
     *
     * @param string $nivelBlindaje
     *
     * @return VhloVehiculo
     */
    public function setNivelBlindaje($nivelBlindaje)
    {
        $this->nivelBlindaje = $nivelBlindaje;

        return $this;
    }

    /**
     * Get nivelBlindaje
     *
     * @return string
     */
    public function getNivelBlindaje()
    {
        return $this->nivelBlindaje;
    }

    /**
     * Set empresaBlindadora
     *
     * @param string $empresaBlindadora
     *
     * @return VhloVehiculo
     */
    public function setEmpresaBlindadora($empresaBlindadora)
    {
        $this->empresaBlindadora = $empresaBlindadora;

        return $this;
    }

    /**
     * Get empresaBlindadora
     *
     * @return string
     */
    public function getEmpresaBlindadora()
    {
        return $this->empresaBlindadora;
    }

    /**
     * Set pignorado
     *
     * @param boolean $pignorado
     *
     * @return VhloVehiculo
     */
    public function setPignorado($pignorado)
    {
        $this->pignorado = $pignorado;

        return $this;
    }

    /**
     * Get pignorado
     *
     * @return boolean
     */
    public function getPignorado()
    {
        return $this->pignorado;
    }

    /**
     * Set cancelado
     *
     * @param boolean $cancelado
     *
     * @return VhloVehiculo
     */
    public function setCancelado($cancelado)
    {
        $this->cancelado = $cancelado;

        return $this;
    }

    /**
     * Get cancelado
     *
     * @return boolean
     */
    public function getCancelado()
    {
        return $this->cancelado;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return VhloVehiculo
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
     * Set linea
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgLinea $linea
     *
     * @return VhloVehiculo
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
     * Set servicio
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgServicio $servicio
     *
     * @return VhloVehiculo
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
     * Set color
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgColor $color
     *
     * @return VhloVehiculo
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
     * Set combustible
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgCombustible $combustible
     *
     * @return VhloVehiculo
     */
    public function setCombustible(\JHWEB\VehiculoBundle\Entity\VhloCfgCombustible $combustible = null)
    {
        $this->combustible = $combustible;

        return $this;
    }

    /**
     * Get combustible
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgCombustible
     */
    public function getCombustible()
    {
        return $this->combustible;
    }

    /**
     * Set carroceria
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgCarroceria $carroceria
     *
     * @return VhloVehiculo
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

    /**
     * Set clase
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgClase $clase
     *
     * @return VhloVehiculo
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
     * @return VhloVehiculo
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
     * @return VhloVehiculo
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
     * Set nacionalidad
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgNacionalidad $nacionalidad
     *
     * @return VhloVehiculo
     */
    public function setNacionalidad(\JHWEB\SeguridadVialBundle\Entity\SvCfgNacionalidad $nacionalidad = null)
    {
        $this->nacionalidad = $nacionalidad;

        return $this;
    }

    /**
     * Get nacionalidad
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgNacionalidad
     */
    public function getNacionalidad()
    {
        return $this->nacionalidad;
    }

    /**
     * Set placa
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgPlaca $placa
     *
     * @return VhloVehiculo
     */
    public function setPlaca(\JHWEB\VehiculoBundle\Entity\VhloCfgPlaca $placa = null)
    {
        $this->placa = $placa;

        return $this;
    }

    /**
     * Get placa
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgPlaca
     */
    public function getPlaca()
    {
        return $this->placa;
    }

    /**
     * Set pais
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgPais $pais
     *
     * @return VhloVehiculo
     */
    public function setPais(\JHWEB\ConfigBundle\Entity\CfgPais $pais = null)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgPais
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set municipio
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgMunicipio $municipio
     *
     * @return VhloVehiculo
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
     * Set organismoTransito
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgOrganismoTransito $organismoTransito
     *
     * @return VhloVehiculo
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
     * Set empresa
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserEmpresa $empresa
     *
     * @return VhloVehiculo
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
