<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Consumibles
 *
 * @ORM\Table(name="consumibles")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConsumiblesRepository")
 */
class Consumible
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Almacen", mappedBy="consumible")
     */
    protected $almacenes;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Vehiculo", mappedBy="combustible")
     */
    protected $vehiculos; 

    public function __construct() {
        $this->almacenes = new \Doctrine\Common\Collections\ArrayCollection();
         $this->vehiculos = new \Doctrine\Common\Collections\ArrayCollection();
        
    }
     public function __toString()
    {
        return $this->getNombre();
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Consumible
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Add almacene
     *
     * @param \AppBundle\Entity\Almacen $almacene
     *
     * @return Consumible
     */
    public function addAlmacene(\AppBundle\Entity\Almacen $almacene)
    {
        $this->almacenes[] = $almacene;

        return $this;
    }

    /**
     * Remove almacene
     *
     * @param \AppBundle\Entity\Almacen $almacene
     */
    public function removeAlmacene(\AppBundle\Entity\Almacen $almacene)
    {
        $this->almacenes->removeElement($almacene);
    }

    /**
     * Get almacenes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAlmacenes()
    {
        return $this->almacenes;
    }

    /**
     * Add vehiculo
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculo
     *
     * @return Consumible
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