<?php

namespace AppBundle\Entity;
 
use Doctrine\ORM\Mapping as ORM;

/**
 * Clase
 *
 * @ORM\Table(name="clase")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClaseRepository")
 */
class Clase
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
     * @var int
     *
     * @ORM\Column(name="codigoMt", type="integer", unique=true)
     */
    private $codigoMt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Carroceria", mappedBy="clase")
     */
    protected $carrocerias; 

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Almacen", mappedBy="clase")
     */
    protected $almacenes; 

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Vehiculo", mappedBy="clase")
     */
    protected $vehiculos;


    public function __construct() {
        $this->carrocerias = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Clase
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
     * Set codigoMt
     *
     * @param integer $codigoMt
     *
     * @return Clase
     */
    public function setCodigoMt($codigoMt)
    {
        $this->codigoMt = $codigoMt;

        return $this;
    }

    /**
     * Get codigoMt
     *
     * @return integer
     */
    public function getCodigoMt()
    {
        return $this->codigoMt;
    }

    /**
     * Add carroceria
     *
     * @param \AppBundle\Entity\Carroceria $carroceria
     *
     * @return Clase
     */
    public function addCarroceria(\AppBundle\Entity\Carroceria $carroceria)
    {
        $this->carrocerias[] = $carroceria;

        return $this;
    }

    /**
     * Remove carroceria
     *
     * @param \AppBundle\Entity\Carroceria $carroceria
     */
    public function removeCarroceria(\AppBundle\Entity\Carroceria $carroceria)
    {
        $this->carrocerias->removeElement($carroceria);
    }

    /**
     * Get carrocerias
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCarrocerias()
    {
        return $this->carrocerias;
    }

    /**
     * Add almacene
     *
     * @param \AppBundle\Entity\Almacen $almacene
     *
     * @return Clase
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
     * @return Clase
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

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return Clase
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
}
