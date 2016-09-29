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
     * @var string
     *
     * @ORM\Column(name="placa", type="string", length=255)
     */
    private $placa;

    /**
     * @var int
     *
     * @ORM\Column(name="numeroFactura", type="integer")
     */
    private $numeroFactura;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaFactura", type="datetime")
     */
    private $fechaFactura;

    /**
     * @var string
     *
     * @ORM\Column(name="valor", type="string", length=255)
     */
    private $valor;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroManifiesto", type="string", length=255)
     */
    private $numeroManifiesto;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaManifiesto", type="datetime")
     */
    private $fechaManifiesto;

    /**
     * @var string
     *
     * @ORM\Column(name="cilindraje", type="string", length=255)
     */
    private $cilindraje;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modelo", type="date")
     */
    private $modelo;

    /**
     * @var string
     *
     * @ORM\Column(name="motor", type="string", length=255)
     */
    private $motor;

    /**
     * @var string
     *
     * @ORM\Column(name="chasis", type="string", length=255)
     */
    private $chasis;

    /**
     * @var string
     *
     * @ORM\Column(name="serie", type="string", length=255)
     */
    private $serie;
  
    /**
     * @var int
     *
     * @ORM\Column(name="vin", type="integer")
     */
    private $vin;

    /**
     * @var int
     *
     * @ORM\Column(name="pasajeros", type="integer")
     */
    private $pasajeros;

    /**
     * @var string
     *
     * @ORM\Column(name="estadoVehiculo", type="string", length=255)
     */
    private $estadoVehiculo;
    

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ciudad", inversedBy="vehiculos") */
    private $ciudad; 

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Servicio", inversedBy="vehiculos") */
    private $servicio; 

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Linea", inversedBy="vehiculos") */
    private $linea; 

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Combustible", inversedBy="vehiculos") */
    private $combustible; 

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organismo", inversedBy="vehiculos") */
    private $organismo;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Carroceria", inversedBy="vehiculos") */
    private $carroceria;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Color", inversedBy="vehiculos") */
    private $color;

     /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Clase", inversedBy="vehiculos") */
    private $clase; 

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Propietario_Vehiculo", mappedBy="vehiculo")
     */
    protected $propietarios_Vehiculo;  

    public function __construct() {
        $this->propietarios_Vehiculo = new \Doctrine\Common\Collections\ArrayCollection();
        
    } 


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
     * @return Vehiculo
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
     * @return int
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
        return $this->fechaFactura;
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
        return $this->fechaManifiesto;
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
     * @param \DateTime $modelo
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
     * @return \DateTime
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
     * @param integer $vin
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
     * @return int
     */
    public function getVin()
    {
        return $this->vin;
    }

    /**
     * Set pasajeros
     *
     * @param integer $pasajeros
     *
     * @return Vehiculo
     */
    public function setPasajeros($pasajeros)
    {
        $this->pasajeros = $pasajeros;

        return $this;
    }

    /**
     * Get pasajeros
     *
     * @return int
     */
    public function getPasajeros()
    {
        return $this->pasajeros;
    }

    /**
     * Set estadoVehiculo
     *
     * @param string $estadoVehiculo
     *
     * @return Vehiculo
     */
    public function setEstadoVehiculo($estadoVehiculo)
    {
        $this->estadoVehiculo = $estadoVehiculo;

        return $this;
    }

    /**
     * Get estadoVehiculo
     *
     * @return string
     */
    public function getEstadoVehiculo()
    {
        return $this->estadoVehiculo;
    }

    /**
     * Set ciudad
     *
     * @param \AppBundle\Entity\Ciudad $ciudad
     *
     * @return Vehiculo
     */
    public function setCiudad(\AppBundle\Entity\Ciudad $ciudad = null)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get ciudad
     *
     * @return \AppBundle\Entity\Ciudad
     */
    public function getCiudad()
    {
        return $this->ciudad;
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
        return $this->servicio;
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
        return $this->linea;
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
        return $this->combustible;
    }

    /**
     * Set organismo
     *
     * @param \AppBundle\Entity\Combustible $organismo
     *
     * @return Vehiculo
     */
   

    /**
     * Set organismo
     *
     * @param \AppBundle\Entity\Organismo $organismo
     *
     * @return Vehiculo
     */
    public function setOrganismo(\AppBundle\Entity\Organismo $organismo = null)
    {
        $this->organismo = $organismo;

        return $this;
    }

    /**
     * Get organismo
     *
     * @return \AppBundle\Entity\Organismo
     */
    public function getOrganismo()
    {
        return $this->organismo;
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
        return $this->carroceria;
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
        return $this->color;
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
        return $this->clase;
    }

    /**
     * Add propietariosVehiculo
     *
     * @param \AppBundle\Entity\Propietario_Vehiculo $propietariosVehiculo
     *
     * @return Vehiculo
     */
    public function addPropietariosVehiculo(\AppBundle\Entity\Propietario_Vehiculo $propietariosVehiculo)
    {
        $this->propietarios_Vehiculo[] = $propietariosVehiculo;

        return $this;
    }

    /**
     * Remove propietariosVehiculo
     *
     * @param \AppBundle\Entity\Propietario_Vehiculo $propietariosVehiculo
     */
    public function removePropietariosVehiculo(\AppBundle\Entity\Propietario_Vehiculo $propietariosVehiculo)
    {
        $this->propietarios_Vehiculo->removeElement($propietariosVehiculo);
    }

    /**
     * Get propietariosVehiculo
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPropietariosVehiculo()
    {
        return $this->propietarios_Vehiculo;
    }
}
