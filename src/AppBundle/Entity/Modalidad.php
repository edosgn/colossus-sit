<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modalidad
 *
 * @ORM\Table(name="modalidad")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModalidadRepository")
 */
class Modalidad
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
     * @ORM\Column(name="codigoMt", type="integer")
     */
    private $codigoMt;


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\VehiculoPesado", mappedBy="modalidad")
     */
    protected $vehiculosPesado;  

    public function __construct() {
        $this->propietariosVehiculo = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Modalidad
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
     * @return Modalidad
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
     * Add vehiculosPesado
     *
     * @param \AppBundle\Entity\VehiculoPesado $vehiculosPesado
     *
     * @return Modalidad
     */
    public function addVehiculosPesado(\AppBundle\Entity\VehiculoPesado $vehiculosPesado)
    {
        $this->vehiculosPesado[] = $vehiculosPesado;

        return $this;
    }

    /**
     * Remove vehiculosPesado
     *
     * @param \AppBundle\Entity\VehiculoPesado $vehiculosPesado
     */
    public function removeVehiculosPesado(\AppBundle\Entity\VehiculoPesado $vehiculosPesado)
    {
        $this->vehiculosPesado->removeElement($vehiculosPesado);
    }

    /**
     * Get vehiculosPesado
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVehiculosPesado()
    {
        return $this->vehiculosPesado;
    }
}