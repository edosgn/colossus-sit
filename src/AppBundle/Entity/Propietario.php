<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
 
/**
 * Propietario
 *
 * @ORM\Table(name="propietario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PropietarioRepository")
 */
class Propietario
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
     * @var int
     *
     * @ORM\Column(name="numeroId", type="integer")
     */
    private $numeroId;

    /**
     * @var string
     *
     * @ORM\Column(name="nombresPropietario", type="string", length=255)
     */
    private $nombresPropietario;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidosPropietario", type="string", length=255)
     */
    private $apellidosPropietario;

    /**
     * @var string
     *
     * @ORM\Column(name="direccionPropietario", type="string", length=255)
     */
    private $direccionPropietario;

    /**
     * @var string
     *
     * @ORM\Column(name="telefonoPropietario", type="string", length=255)
     */
    private $telefonoPropietario;

    /**
     * @var string
     *
     * @ORM\Column(name="correoPropietario", type="string", length=255)
     */
    private $correoPropietario;


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Propietario_Vehiculo", mappedBy="propietario")
     */
    protected $propietarios_Vehiculo;  

    public function __construct() {
        $this->propietarios_Vehiculo = new \Doctrine\Common\Collections\ArrayCollection();
        
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
     * Set numeroId
     *
     * @param integer $numeroId
     *
     * @return Propietario
     */
    public function setNumeroId($numeroId)
    {
        $this->numeroId = $numeroId;

        return $this;
    }

    /**
     * Get numeroId
     *
     * @return int
     */
    public function getNumeroId()
    {
        return $this->numeroId;
    }

    /**
     * Set nombresPropietario
     *
     * @param string $nombresPropietario
     *
     * @return Propietario
     */
    public function setNombresPropietario($nombresPropietario)
    {
        $this->nombresPropietario = $nombresPropietario;

        return $this;
    }

    /**
     * Get nombresPropietario
     *
     * @return string
     */
    public function getNombresPropietario()
    {
        return $this->nombresPropietario;
    }

    /**
     * Set apellidosPropietario
     *
     * @param string $apellidosPropietario
     *
     * @return Propietario
     */
    public function setApellidosPropietario($apellidosPropietario)
    {
        $this->apellidosPropietario = $apellidosPropietario;

        return $this;
    }

    /**
     * Get apellidosPropietario
     *
     * @return string
     */
    public function getApellidosPropietario()
    {
        return $this->apellidosPropietario;
    }

    /**
     * Set direccionPropietario
     *
     * @param string $direccionPropietario
     *
     * @return Propietario
     */
    public function setDireccionPropietario($direccionPropietario)
    {
        $this->direccionPropietario = $direccionPropietario;

        return $this;
    }

    /**
     * Get direccionPropietario
     *
     * @return string
     */
    public function getDireccionPropietario()
    {
        return $this->direccionPropietario;
    }

    /**
     * Set telefonoPropietario
     *
     * @param string $telefonoPropietario
     *
     * @return Propietario
     */
    public function setTelefonoPropietario($telefonoPropietario)
    {
        $this->telefonoPropietario = $telefonoPropietario;

        return $this;
    }

    /**
     * Get telefonoPropietario
     *
     * @return string
     */
    public function getTelefonoPropietario()
    {
        return $this->telefonoPropietario;
    }

    /**
     * Set correoPropietario
     *
     * @param string $correoPropietario
     *
     * @return Propietario
     */
    public function setCorreoPropietario($correoPropietario)
    {
        $this->correoPropietario = $correoPropietario;

        return $this;
    }

    /**
     * Get correoPropietario
     *
     * @return string
     */
    public function getCorreoPropietario()
    {
        return $this->correoPropietario;
    }

    /**
     * Add propietariosVehiculo
     *
     * @param \AppBundle\Entity\Propietario_Vehiculo $propietariosVehiculo
     *
     * @return Propietario
     */
    public function addPropietariosVehiculo(\AppBundle\Entity\Propietario_Vehiculo $propietariosVehiculo)
    {
        $this->propietarios_Vehiculo[] = $propietariosVehiculo;

        return $this;
    }

    /**
     * Remove propietariosVehiculo
     *
     * @param \AppBundle\Entity\Propietario_Vehiculo $propietariosVehiculo
     */
    public function removePropietariosVehiculo(\AppBundle\Entity\Propietario_Vehiculo $propietariosVehiculo)
    {
        $this->propietarios_Vehiculo->removeElement($propietariosVehiculo);
    }

    /**
     * Get propietariosVehiculo
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPropietariosVehiculo()
    {
        return $this->propietarios_Vehiculo;
    }
}
