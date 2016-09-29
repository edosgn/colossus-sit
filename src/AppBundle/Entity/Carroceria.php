<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Carroceria
 *
 * @ORM\Table(name="carroceria")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CarroceriaRepository")
 */
class Carroceria
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
     * @ORM\Column(name="nombreCarroceria", type="string", length=255)
     */
    private $nombreCarroceria;

    /**
     * @var int
     *
     * @ORM\Column(name="codigoCarroceria", type="integer", unique=true)
     */
    private $codigoCarroceria;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Clase", inversedBy="carrocerias") */
    private $clase; 

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Vehiculo", mappedBy="carroceria")
     */
    protected $vehiculos;  

    public function __construct() {
        $this->vehiculos = new \Doctrine\Common\Collections\ArrayCollection();
        
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
     * Set nombreCarroceria
     *
     * @param string $nombreCarroceria
     *
     * @return Carroceria
     */
    public function setNombreCarroceria($nombreCarroceria)
    {
        $this->nombreCarroceria = $nombreCarroceria;

        return $this;
    }

    /**
     * Get nombreCarroceria
     *
     * @return string
     */
    public function getNombreCarroceria()
    {
        return $this->nombreCarroceria;
    }

    /**
     * Set codigoCarroceria
     *
     * @param integer $codigoCarroceria
     *
     * @return Carroceria
     */
    public function setCodigoCarroceria($codigoCarroceria)
    {
        $this->codigoCarroceria = $codigoCarroceria;

        return $this;
    }

    /**
     * Get codigoCarroceria
     *
     * @return int
     */
    public function getCodigoCarroceria()
    {
        return $this->codigoCarroceria;
    }

    /**
     * Set clase
     *
     * @param \AppBundle\Entity\Clase $clase
     *
     * @return Carroceria
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
     * Add vehiculo
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculo
     *
     * @return Carroceria
     */
    public function addVehiculo(\AppBundle\Entity\Vehiculo $vehiculo)
    {
        $this->vehiculos[] = $vehiculo;

        return $this;
    }

    /**
     * Remove vehiculo
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculo
     */
    public function removeVehiculo(\AppBundle\Entity\Vehiculo $vehiculo)
    {
        $this->vehiculos->removeElement($vehiculo);
    }

    /**
     * Get vehiculos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVehiculos()
    {
        return $this->vehiculos;
    }
}
