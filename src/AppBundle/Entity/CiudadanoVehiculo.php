<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CiudadanoVehiculo
 *
 * @ORM\Table(name="ciudadano_vehiculo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CiudadanoVehiculoRepository")
 */
class CiudadanoVehiculo
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
     * @ORM\Column(name="licencia_transito", type="string", length=255)
     */
    private $licenciaTransito;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_propiedad_inicial", type="datetime")
     */
    private $fechaPropiedadInicial;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_propiedad_final", type="datetime")
     */
    private $fechaPropiedadFinal;

    /**
     * @var string
     *
     * @ORM\Column(name="estado_propiedad", type="string", length=255)
     */
    private $estadoPropiedad;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ciudadano", inversedBy="ciudadanosVehiculo") */
    private $ciudadano; 

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehiculo", inversedBy="propietariosVehiculo") */
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
     * @return CiudadanoVehiculo
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
     * Set fechaPropiedadInicial
     *
     * @param \DateTime $fechaPropiedadInicial
     *
     * @return CiudadanoVehiculo
     */
    public function setFechaPropiedadInicial($fechaPropiedadInicial)
    {
        $this->fechaPropiedadInicial = new \DateTime($fechaPropiedadInicial);
        return $this;
    }

    /**
     * Get fechaPropiedadInicial
     *
     * @return \DateTime
     */
    public function getFechaPropiedadInicial()
    {
        return $this->fechaPropiedadInicial->format("Y-m-d");
    }

    /**
     * Set fechaPropiedadFinal
     *
     * @param \DateTime $fechaPropiedadFinal
     *
     * @return CiudadanoVehiculo
     */
    public function setFechaPropiedadFinal($fechaPropiedadFinal)
    {
       $this->fechaPropiedadFinal = new \DateTime($fechaPropiedadFinal);
        return $this;
    }

    /**
     * Get fechaPropiedadFinal
     *
     * @return \DateTime
     */
    public function getFechaPropiedadFinal()
    {
        return $this->fechaPropiedadFinal->format("Y-m-d");
    }

    /**
     * Set estadoPropiedad
     *
     * @param string $estadoPropiedad
     *
     * @return CiudadanoVehiculo
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
     * Set ciudadano
     *
     * @param \AppBundle\Entity\Ciudadano $ciudadano
     *
     * @return CiudadanoVehiculo
     */
    public function setCiudadano(\AppBundle\Entity\Ciudadano $ciudadano = null)
    {
        $this->ciudadano = $ciudadano;

        return $this;
    }

    /**
     * Get ciudadano
     *
     * @return \AppBundle\Entity\Ciudadano
     */
    public function getCiudadano()
    {
        return $this->ciudadano;
    }

    /**
     * Set vehiculo
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculo
     *
     * @return CiudadanoVehiculo
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

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return CiudadanoVehiculo
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
