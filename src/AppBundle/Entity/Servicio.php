<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Servicio
 *
 * @ORM\Table(name="servicio")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ServicioRepository")
 */
class Servicio
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
     * @ORM\Column(name="nombreServicio", type="string", length=255)
     */
    private $nombreServicio;

    /**
     * @var int
     *
     * @ORM\Column(name="codigoServicio", type="integer", unique=true)
     */
    private $codigoServicio;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Almacen", mappedBy="servicio")
     */
    protected $almacenes;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Vehiculo", mappedBy="servicio")
     */
    protected $vehiculos;  

    public function __construct() {
        $this->almacenes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombreServicio
     *
     * @param string $nombreServicio
     *
     * @return Servicio
     */
    public function setNombreServicio($nombreServicio)
    {
        $this->nombreServicio = $nombreServicio;

        return $this;
    }

    /**
     * Get nombreServicio
     *
     * @return string
     */
    public function getNombreServicio()
    {
        return $this->nombreServicio;
    }

    /**
     * Set codigoServicio
     *
     * @param integer $codigoServicio
     *
     * @return Servicio
     */
    public function setCodigoServicio($codigoServicio)
    {
        $this->codigoServicio = $codigoServicio;

        return $this;
    }

    /**
     * Get codigoServicio
     *
     * @return integer
     */
    public function getCodigoServicio()
    {
        return $this->codigoServicio;
    }

    /**
     * Add almacene
     *
     * @param \AppBundle\Entity\Almacen $almacene
     *
     * @return Servicio
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
     * @return Servicio
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
