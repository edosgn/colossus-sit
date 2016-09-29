<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CargaPasajero
 *
 * @ORM\Table(name="carga_pasajero")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CargaPasajeroRepository")
 */
class Carga_Pasajero
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
     * @ORM\Column(name="tonelaje", type="string", length=255)
     */
    private $tonelaje;

    /**
     * @var int
     *
     * @ORM\Column(name="numeroEjes", type="integer")
     */
    private $numeroEjes;

    /**
     * @var int
     *
     * @ORM\Column(name="numeroPasajeros", type="integer")
     */
    private $numeroPasajeros;

    /**
     * @var int
     *
     * @ORM\Column(name="numeroMotor", type="integer")
     */
    private $numeroMotor;

    /**
     * @var string
     *
     * @ORM\Column(name="fthCarroceria", type="string", length=255)
     */
    private $fthCarroceria;

    /**
     * @var string
     *
     * @ORM\Column(name="fthChasis", type="string", length=255)
     */
    private $fthChasis;

     /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehiculo", inversedBy="cargasPasajero") */
    private $vehiculo;


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
     * Set tonelaje
     *
     * @param string $tonelaje
     *
     * @return CargaPasajero
     */
    public function setTonelaje($tonelaje)
    {
        $this->tonelaje = $tonelaje;

        return $this;
    }

    /**
     * Get tonelaje
     *
     * @return string
     */
    public function getTonelaje()
    {
        return $this->tonelaje;
    }

    /**
     * Set numeroEjes
     *
     * @param integer $numeroEjes
     *
     * @return CargaPasajero
     */
    public function setNumeroEjes($numeroEjes)
    {
        $this->numeroEjes = $numeroEjes;

        return $this;
    }

    /**
     * Get numeroEjes
     *
     * @return int
     */
    public function getNumeroEjes()
    {
        return $this->numeroEjes;
    }

    /**
     * Set numeroPasajeros
     *
     * @param integer $numeroPasajeros
     *
     * @return CargaPasajero
     */
    public function setNumeroPasajeros($numeroPasajeros)
    {
        $this->numeroPasajeros = $numeroPasajeros;

        return $this;
    }

    /**
     * Get numeroPasajeros
     *
     * @return int
     */
    public function getNumeroPasajeros()
    {
        return $this->numeroPasajeros;
    }

    /**
     * Set numeroMotor
     *
     * @param integer $numeroMotor
     *
     * @return CargaPasajero
     */
    public function setNumeroMotor($numeroMotor)
    {
        $this->numeroMotor = $numeroMotor;

        return $this;
    }

    /**
     * Get numeroMotor
     *
     * @return int
     */
    public function getNumeroMotor()
    {
        return $this->numeroMotor;
    }

    /**
     * Set fthCarroceria
     *
     * @param string $fthCarroceria
     *
     * @return CargaPasajero
     */
    public function setFthCarroceria($fthCarroceria)
    {
        $this->fthCarroceria = $fthCarroceria;

        return $this;
    }

    /**
     * Get fthCarroceria
     *
     * @return string
     */
    public function getFthCarroceria()
    {
        return $this->fthCarroceria;
    }

    /**
     * Set fthChasis
     *
     * @param string $fthChasis
     *
     * @return CargaPasajero
     */
    public function setFthChasis($fthChasis)
    {
        $this->fthChasis = $fthChasis;

        return $this;
    }

    /**
     * Get fthChasis
     *
     * @return string
     */
    public function getFthChasis()
    {
        return $this->fthChasis;
    }

    /**
     * Set vehiculo
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculo
     *
     * @return Carga_Pasajero
     */
    public function setVehiculo(\AppBundle\Entity\Vehiculo $vehiculo = null)
    {
        $this->vehiculo = $vehiculo;

        return $this;
    }

    /**
     * Get vehiculo
     *
     * @return \AppBundle\Entity\Vehiculo
     */
    public function getVehiculo()
    {
        return $this->vehiculo;
    }
}
