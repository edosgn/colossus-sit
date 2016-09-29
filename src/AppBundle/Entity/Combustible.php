<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Combustible
 *
 * @ORM\Table(name="combustible")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CombustibleRepository")
 */
class Combustible
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
     * @ORM\Column(name="nombreCombustible", type="string", length=255)
     */
    private $nombreCombustible;

    /**
     * @var int
     *
     * @ORM\Column(name="codigoCombustible", type="integer", unique=true)
     */
    private $codigoCombustible;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Vehiculo", mappedBy="combustible")
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
     * Set nombreCombustible
     *
     * @param string $nombreCombustible
     *
     * @return Combustible
     */
    public function setNombreCombustible($nombreCombustible)
    {
        $this->nombreCombustible = $nombreCombustible;

        return $this;
    }

    /**
     * Get nombreCombustible
     *
     * @return string
     */
    public function getNombreCombustible()
    {
        return $this->nombreCombustible;
    }

    /**
     * Set codigoCombustible
     *
     * @param integer $codigoCombustible
     *
     * @return Combustible
     */
    public function setCodigoCombustible($codigoCombustible)
    {
        $this->codigoCombustible = $codigoCombustible;

        return $this;
    }

    /**
     * Get codigoCombustible
     *
     * @return int
     */
    public function getCodigoCombustible()
    {
        return $this->codigoCombustible;
    }

    /**
     * Add vehiculo
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculo
     *
     * @return Combustible
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
