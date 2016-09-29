<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM; 

/**
 * Propietario_Vehiculo
 *
 * @ORM\Table(name="propietario__vehiculo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Propietario_VehiculoRepository")
 */
class Propietario_Vehiculo
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
     * @ORM\Column(name="licenciaTransito", type="string", length=255)
     */
    private $licenciaTransito;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaPropiedad", type="datetime")
     */
    private $fechaPropiedad;

    /**
     * @var string
     *
     * @ORM\Column(name="estadoPropiedad", type="string", length=255)
     */
    private $estadoPropiedad;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Propietario", inversedBy="propietarios_Vehiculo") */
    private $propietario; 

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehiculo", inversedBy="propietarios_Vehiculo") */
    private $vehiculo; 


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
     * Set licenciaTransito
     *
     * @param string $licenciaTransito
     *
     * @return Propietario_Vehiculo
     */
    public function setLicenciaTransito($licenciaTransito)
    {
        $this->licenciaTransito = $licenciaTransito;

        return $this;
    }

    /**
     * Get licenciaTransito
     *
     * @return string
     */
    public function getLicenciaTransito()
    {
        return $this->licenciaTransito;
    }

    /**
     * Set fechaPropiedad
     *
     * @param \DateTime $fechaPropiedad
     *
     * @return Propietario_Vehiculo
     */
    public function setFechaPropiedad($fechaPropiedad)
    {
        $this->fechaPropiedad = $fechaPropiedad;

        return $this;
    }

    /**
     * Get fechaPropiedad
     *
     * @return \DateTime
     */
    public function getFechaPropiedad()
    {
        return $this->fechaPropiedad;
    }

    /**
     * Set estadoPropiedad
     *
     * @param string $estadoPropiedad
     *
     * @return Propietario_Vehiculo
     */
    public function setEstadoPropiedad($estadoPropiedad)
    {
        $this->estadoPropiedad = $estadoPropiedad;

        return $this;
    }

    /**
     * Get estadoPropiedad
     *
     * @return string
     */
    public function getEstadoPropiedad()
    {
        return $this->estadoPropiedad;
    }

    /**
     * Set propietario
     *
     * @param \AppBundle\Entity\Propietario $propietario
     *
     * @return Propietario_Vehiculo
     */
    public function setPropietario(\AppBundle\Entity\Propietario $propietario = null)
    {
        $this->propietario = $propietario;

        return $this;
    }

    /**
     * Get propietario
     *
     * @return \AppBundle\Entity\Propietario
     */
    public function getPropietario()
    {
        return $this->propietario;
    }

    /**
     * Set vehiculo
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculo
     *
     * @return Propietario_Vehiculo
     */
    public function setVehiculo(\AppBundle\Entity\Vehiculo $vehiculo = null)
    {
        $this->vehiculo = $vehiculo;

        return $this;
    }

    /**
     * Get vehiculo
     *
     * @return \AppBundle\Entity\Vehiculo
     */
    public function getVehiculo()
    {
        return $this->vehiculo;
    }
}
