<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Organismo
 *
 * @ORM\Table(name="organismo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrganismoRepository")
 */
class Organismo
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
     * @ORM\Column(name="nombreOrganismo", type="string", length=255)
     */
    private $nombreOrganismo;

    

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Almacen", mappedBy="organismo")
     */
    protected $almacenes; 

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Vehiculo", mappedBy="organismo")
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
     * Set nombreOrganismo
     *
     * @param string $nombreOrganismo
     *
     * @return Organismo
     */
    public function setNombreOrganismo($nombreOrganismo)
    {
        $this->nombreOrganismo = $nombreOrganismo;

        return $this;
    }

    /**
     * Get nombreOrganismo
     *
     * @return string
     */
    public function getNombreOrganismo()
    {
        return $this->nombreOrganismo;
    }

    /**
     * Add almacene
     *
     * @param \AppBundle\Entity\Almacen $almacene
     *
     * @return Organismo
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
     * @return Organismo
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
