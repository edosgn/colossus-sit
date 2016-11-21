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
     * @ORM\Column(name="numero_factura", type="integer")
     */
    private $numeroFactura;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_factura", type="datetime")
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
     * @ORM\Column(name="numero_manifiesto", type="string", length=255)
     */
    private $numeroManifiesto;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_manifiesto", type="datetime")
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
     * @ORM\Column(name="vin", type="bigint")
     */
    private $vin;

    /**
     * @var int
     *
     * @ORM\Column(name="numero_pasajeros", type="integer")
     */
    private $numeroPasajeros;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /**
     * @var boolean
     *
     * @ORM\Column(name="pignorado", type="boolean")
     */
    private $pignorado;

    /**
     * @var boolean
     *
     * @ORM\Column(name="cancelado", type="boolean")
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

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\OrganismoTransito", inversedBy="vehiculos") */
    private $organismoTransito;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Clase", inversedBy="vehiculos") */
    private $clase;



    public function __toString()
    {
        return $this->getPlaca();
    }

   

   

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
        $this->fechaFactura = new \Datetime($fechaFactura);

        return $this;
    }

    /**
     * Get fechaFactura
     *
     * @return \DateTime
     */
    public function getFechaFactura()
    {
        return $this->fechaFactura->format('Y-m-d');
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
        $this->fechaManifiesto = new Datetime($fechaManifiesto);

        return $this;
    }

    /**
     * Get fechaManifiesto
     *
     * @return \DateTime
     */
    public function getFechaManifiesto()
    {
        return $this->fechaManifiesto->format('Y-m-d');
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
        $this->modelo = new Datetime($modelo);

        return $this;
    }

    /**
     * Get modelo
     *
     * @return \DateTime
     */
    public function getModelo()
    {
        return $this->modelo->format('Y');
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
     * @return integer
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
        return $this->cancelado;
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
        return $this->municipio;
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
     * Set organismoTransito
     *
     * @param \AppBundle\Entity\OrganismoTransito $organismoTransito
     *
     * @return Vehiculo
     */
    public function setOrganismoTransito(\AppBundle\Entity\OrganismoTransito $organismoTransito = null)
    {
        $this->organismoTransito = $organismoTransito;

        return $this;
    }

    /**
     * Get organismoTransito
     *
     * @return \AppBundle\Entity\OrganismoTransito
     */
    public function getOrganismoTransito()
    {
        return $this->organismoTransito;
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
}
