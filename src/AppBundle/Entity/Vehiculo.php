<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vehiculo
 *
 * @ORM\Table(name="vehiculo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VehiculoRepository")
 */
class Vehiculo
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
     * @var int
     *
     * @ORM\Column(name="numero_pasajeros", type="integer", nullable= true)
     */
    private $numeroPasajeros;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado = true;

    /**
     * @var boolean
     *
     * @ORM\Column(name="leasing", type="boolean", nullable=true)
     */
    private $leasing;

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
    

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Municipio", inversedBy="vehiculos") */
    private $municipio; 

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Linea", inversedBy="vehiculos") */
    private $linea;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Servicio", inversedBy="vehiculos") */
    private $servicio; 

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Color", inversedBy="vehiculos") */
    private $color;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Combustible", inversedBy="vehiculos") */
    private $combustible; 

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Carroceria", inversedBy="vehiculos") */
    private $carroceria;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Clase", inversedBy="vehiculos") */
    private $clase;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\CfgPlaca", inversedBy="vehiculos") */
    private $placa;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\SedeOperativa", inversedBy="vehiculos") */
    private $sedeOperativa;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\CfgRadioAccion", inversedBy="vehiculos") */
    private $radioAccion;

    /** @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloCfgModalidadTransporte", inversedBy="vehiculos") */
    private $modalidadTransporte;    

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
     * Set numeroFactura
     *
     * @param integer $numeroFactura
     *
     * @return Vehiculo
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
     * @return Vehiculo
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
        if ($this->fechaFactura) {
            return $this->fechaFactura->format('Y-m-d');
        }else{
            return $this->fechaFactura;
        }
    }

    /**
     * Set valor
     *
     * @param string $valor
     *
     * @return Vehiculo
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
     * @return Vehiculo
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
     * @return Vehiculo
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
        if ($this->fechaManifiesto) {
            return $this->fechaManifiesto->format('Y-m-d');
        }else{
            return $this->fechaManifiesto;
        }
        
    }

    /**
     * Set cilindraje
     *
     * @param string $cilindraje
     *
     * @return Vehiculo
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
     * @return Vehiculo
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
     * @return Vehiculo
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
     * @return Vehiculo
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
     * @return Vehiculo
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
     * @return Vehiculo
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
     * Set numeroPasajeros
     *
     * @param integer $numeroPasajeros
     *
     * @return Vehiculo
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
     * Set estado
     *
     * @param boolean $estado
     *
     * @return Vehiculo
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
     * Set leasing
     *
     * @param boolean $leasing
     *
     * @return Vehiculo
     */
    public function setLeasing($leasing)
    {
        $this->leasing = $leasing;

        return $this;
    }

    /**
     * Get leasing
     *
     * @return boolean
     */
    public function getLeasing()
    {
        return $this->leasing;
    }

    /**
     * Set pignorado
     *
     * @param boolean $pignorado
     *
     * @return Vehiculo
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
     * @return Vehiculo
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
        if ($this->cancelado) {
            return $this->cancelado;
        }else{
            return "";
        }
        // return $this->cancelado;
    }

    /**
     * Set municipio
     *
     * @param \AppBundle\Entity\Municipio $municipio
     *
     * @return Vehiculo
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
        if ($this->municipio) {
            return $this->municipio;
        }else{
            return "";
        }

        // return $this->municipio;
    }

    /**
     * Set linea
     *
     * @param \AppBundle\Entity\Linea $linea
     *
     * @return Vehiculo
     */
    public function setLinea(\AppBundle\Entity\Linea $linea = null)
    {
        $this->linea = $linea;

        return $this;
    }

    /**
     * Get linea
     *
     * @return \AppBundle\Entity\Linea
     */
    public function getLinea()
    {
        if ($this->linea) {
            return $this->linea;
        }else{
            return "";
        }
        // return $this->linea;
    }

    /**
     * Set servicio
     *
     * @param \AppBundle\Entity\Servicio $servicio
     *
     * @return Vehiculo
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
        if ($this->servicio) {
            return $this->servicio;
        }else{
            return "";
        }

        // return $this->servicio;
    }

    /**
     * Set color
     *
     * @param \AppBundle\Entity\Color $color
     *
     * @return Vehiculo
     */
    public function setColor(\AppBundle\Entity\Color $color = null)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return \AppBundle\Entity\Color
     */
    public function getColor()
    {
        if ($this->color) {
            return $this->color;
        }else{
            return "";
        }
        // return $this->color;
    }

    /**
     * Set combustible
     *
     * @param \AppBundle\Entity\Combustible $combustible
     *
     * @return Vehiculo
     */
    public function setCombustible(\AppBundle\Entity\Combustible $combustible = null)
    {
        $this->combustible = $combustible;

        return $this;
    }

    /**
     * Get combustible
     *
     * @return \AppBundle\Entity\Combustible
     */
    public function getCombustible()
    {
        if ($this->combustible) {
            return $this->combustible;
        }else{
            return "";
        }
        // return $this->combustible;
    }

    /**
     * Set carroceria
     *
     * @param \AppBundle\Entity\Carroceria $carroceria
     *
     * @return Vehiculo
     */
    public function setCarroceria(\AppBundle\Entity\Carroceria $carroceria = null)
    {
        $this->carroceria = $carroceria;

        return $this;
    }

    /**
     * Get carroceria
     *
     * @return \AppBundle\Entity\Carroceria
     */
    public function getCarroceria()
    {
        if ($this->carroceria) {
            return $this->carroceria;
        }else{
            return "";
        }
        // return $this->carroceria;
    }

    /**
     * Set clase
     *
     * @param \AppBundle\Entity\Clase $clase
     *
     * @return Vehiculo
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
        if ($this->clase) {
            return $this->clase;
        }else{
            return "";
        }
        // return $this->clase;
    }

    /**
     * Set placa
     *
     * @param \AppBundle\Entity\CfgPlaca $placa
     *
     * @return Vehiculo
     */
    public function setPlaca(\AppBundle\Entity\CfgPlaca $placa = null)
    {
        $this->placa = $placa;

        return $this;
    }

    /**
     * Get placa
     *
     * @return \AppBundle\Entity\CfgPlaca
     */
    public function getPlaca()
    {
        if ($this->placa) {
            return $this->placa;
        }else{
            return "";
        }
        // return $this->placa;
    }

    /**
     * Set sedeOperativa
     *
     * @param \AppBundle\Entity\SedeOperativa $sedeOperativa
     *
     * @return Vehiculo
     */
    public function setSedeOperativa(\AppBundle\Entity\SedeOperativa $sedeOperativa = null)
    {
        $this->sedeOperativa = $sedeOperativa;

        return $this;
    }

    /**
     * Get sedeOperativa
     *
     * @return \AppBundle\Entity\SedeOperativa
     */
    public function getSedeOperativa()
    {
        if ($this->sedeOperativa) {
            return $this->sedeOperativa;
        }else{
            return "";
        }
    }

    /**
     * Set radioAccion
     *
     * @param \AppBundle\Entity\CfgRadioAccion $radioAccion
     *
     * @return Vehiculo
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
        if ($this->radioAccion) {
            return $this->radioAccion;
        }else{
            return "";
        }
        // return $this->radioAccion;
    }

    /**
     * Set modalidadTransporte
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgModalidadTransporte $modalidadTransporte
     *
     * @return Vehiculo
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
}
