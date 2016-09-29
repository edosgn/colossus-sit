<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Linea
 *
 * @ORM\Table(name="linea")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LineaRepository")
 */
class Linea 
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
     * @ORM\Column(name="nombreLinea", type="string", length=255)
     */
    private $nombreLinea;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Marca", inversedBy="lineas") */
    private $marca;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Vehiculo", mappedBy="linea")
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
     * Set nombreLinea
     *
     * @param string $nombreLinea
     *
     * @return Linea
     */
    public function setNombreLinea($nombreLinea)
    {
        $this->nombreLinea = $nombreLinea;

        return $this;
    }

    /**
     * Get nombreLinea
     *
     * @return string
     */
    public function getNombreLinea()
    {
        return $this->nombreLinea;
    }

    /**
     * Set marca
     *
     * @param \AppBundle\Entity\Marca $marca
     *
     * @return Linea
     */
    public function setMarca(\AppBundle\Entity\Marca $marca = null)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get marca
     *
     * @return \AppBundle\Entity\Marca
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Add vehiculo
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculo
     *
     * @return Linea
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
