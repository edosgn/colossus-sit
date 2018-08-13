<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CiudadanoVehiculo
 *
 * @ORM\Table(name="propietario_vehiculo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PropietarioVehiculoRepository")
 */
class PropietarioVehiculo
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
     * @ORM\Column(name="licencia_transito", type="string", length=255, nullable= true )
     */
    private $licenciaTransito;

    /**
     * @var boolean
     *
     * @ORM\Column(name="permisoTramite", type="boolean")
     */
    private $permisoTramite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_propiedad_inicial", type="datetime")
     */
    private $fechaPropiedadInicial;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_propiedad_final", type="datetime", nullable= true)
     */
    private $fechaPropiedadFinal;

    /**
     * @var string
     *
     * @ORM\Column(name="estado_propiedad", type="boolean")
     */
    private $estadoPropiedad;


    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ciudadano", inversedBy="propietariosVehiculo") */
    private $ciudadano; 
    
    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ciudadano", inversedBy="propietariosVehiculo") */
    private $apoderado; 

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehiculo", inversedBy="propietariosVehiculo") */
    private $vehiculo;

     /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Empresa", inversedBy="propietariosVehiculo") */
    private $empresa;

    


    /**
     * Get id
     *
     * @return integer
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
     * @return PropietarioVehiculo
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
     * Set permisoTramite
     *
     * @param boolean $permisoTramite
     *
     * @return PropietarioVehiculo
     */
    public function setPermisoTramite($permisoTramite)
    {
        $this->permisoTramite = $permisoTramite;

        return $this;
    }

    /**
     * Get permisoTramite
     *
     * @return boolean
     */
    public function getPermisoTramite()
    {
        return $this->permisoTramite;
    }

    /**
     * Set fechaPropiedadInicial
     *
     * @param \DateTime $fechaPropiedadInicial
     *
     * @return PropietarioVehiculo
     */
    public function setFechaPropiedadInicial($fechaPropiedadInicial)
    {
        $this->fechaPropiedadInicial = $fechaPropiedadInicial;

        return $this;
    }

    /**
     * Get fechaPropiedadInicial
     *
     * @return \DateTime
     */
    public function getFechaPropiedadInicial()
    {
        return $this->fechaPropiedadInicial;
    }

    /**
     * Set fechaPropiedadFinal
     *
     * @param \DateTime $fechaPropiedadFinal
     *
     * @return PropietarioVehiculo
     */
    public function setFechaPropiedadFinal($fechaPropiedadFinal)
    {
        $this->fechaPropiedadFinal = $fechaPropiedadFinal;

        return $this;
    }

    /**
     * Get fechaPropiedadFinal
     *
     * @return \DateTime
     */
    public function getFechaPropiedadFinal()
    {
        return $this->fechaPropiedadFinal;
    }

    /**
     * Set estadoPropiedad
     *
     * @param boolean $estadoPropiedad
     *
     * @return PropietarioVehiculo
     */
    public function setEstadoPropiedad($estadoPropiedad)
    {
        $this->estadoPropiedad = $estadoPropiedad;

        return $this;
    }

    /**
     * Get estadoPropiedad
     *
     * @return boolean
     */
    public function getEstadoPropiedad()
    {
        return $this->estadoPropiedad;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return PropietarioVehiculo
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

    /**
     * Set ciudadano
     *
     * @param \AppBundle\Entity\Ciudadano $ciudadano
     *
     * @return PropietarioVehiculo
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
     * Set apoderado
     *
     * @param \AppBundle\Entity\Ciudadano $apoderado
     *
     * @return PropietarioVehiculo
     */
    public function setApoderado(\AppBundle\Entity\Ciudadano $apoderado = null)
    {
        $this->apoderado = $apoderado;

        return $this;
    }

    /**
     * Get apoderado
     *
     * @return \AppBundle\Entity\Ciudadano
     */
    public function getApoderado()
    {
        return $this->apoderado;
    }

    /**
     * Set vehiculo
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculo
     *
     * @return PropietarioVehiculo
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
     * Set empresa
     *
     * @param \AppBundle\Entity\Empresa $empresa
     *
     * @return PropietarioVehiculo
     */
    public function setEmpresa(\AppBundle\Entity\Empresa $empresa = null)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \AppBundle\Entity\Empresa
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }
}