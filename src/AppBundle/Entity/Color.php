<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Color
 *
 * @ORM\Table(name="color")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ColorRepository")
 */
class Color
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
     * @ORM\Column(name="nombreColor", type="string", length=255)
     */
    private $nombreColor;

    /**
     * @var int
     *
     * @ORM\Column(name="codigoColor", type="integer", unique=true)
     */
    private $codigoColor;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Vehiculo", mappedBy="color")
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
     * Set nombreColor
     *
     * @param string $nombreColor
     *
     * @return Color
     */
    public function setNombreColor($nombreColor)
    {
        $this->nombreColor = $nombreColor;

        return $this;
    }

    /**
     * Get nombreColor
     *
     * @return string
     */
    public function getNombreColor()
    {
        return $this->nombreColor;
    }

    /**
     * Set codigoColor
     *
     * @param integer $codigoColor
     *
     * @return Color
     */
    public function setCodigoColor($codigoColor)
    {
        $this->codigoColor = $codigoColor;

        return $this;
    }

    /**
     * Get codigoColor
     *
     * @return int
     */
    public function getCodigoColor()
    {
        return $this->codigoColor;
    }

    /**
     * Add vehiculo
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculo
     *
     * @return Color
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
