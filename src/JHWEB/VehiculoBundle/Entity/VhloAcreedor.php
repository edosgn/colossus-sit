<?php

namespace JHWEB\VehiculoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VhloAcreedor
 *
 * @ORM\Table(name="vhlo_acreedor")
 * @ORM\Entity(repositoryClass="JHWEB\VehiculoBundle\Repository\VhloAcreedorRepository")
 */
class VhloAcreedor
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
     * @ORM\Column(name="grado_alerta", type="integer", nullable= true)
     */
    private $gradoAlerta;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;
    
    /** @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserCiudadano", inversedBy="acreedores") */
    private $ciudadano; 
 
    /** @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserEmpresa", inversedBy="acreedores") */
    private $empresa;

    /** @ORM\ManyToOne(targetEntity="VhloPropietario", inversedBy="acreedores") */
    private $propietario; 

    /** @ORM\ManyToOne(targetEntity="VhloCfgTipoAlerta", inversedBy="acreedores") */
    private $tipoAlerta;

    /** @ORM\ManyToOne(targetEntity="VhloVehiculo", inversedBy="acreedores") */
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
     * Set gradoAlerta
     *
     * @param integer $gradoAlerta
     *
     * @return VhloAcreedor
     */
    public function setGradoAlerta($gradoAlerta)
    {
        $this->gradoAlerta = $gradoAlerta;

        return $this;
    }

    /**
     * Get gradoAlerta
     *
     * @return integer
     */
    public function getGradoAlerta()
    {
        return $this->gradoAlerta;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return VhloAcreedor
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set ciudadano
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserCiudadano $ciudadano
     *
     * @return VhloAcreedor
     */
    public function setCiudadano(\JHWEB\UsuarioBundle\Entity\UserCiudadano $ciudadano = null)
    {
        $this->ciudadano = $ciudadano;

        return $this;
    }

    /**
     * Get ciudadano
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserCiudadano
     */
    public function getCiudadano()
    {
        return $this->ciudadano;
    }

    /**
     * Set empresa
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserEmpresa $empresa
     *
     * @return VhloAcreedor
     */
    public function setEmpresa(\JHWEB\UsuarioBundle\Entity\UserEmpresa $empresa = null)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserEmpresa
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set propietario
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloPropietario $propietario
     *
     * @return VhloAcreedor
     */
    public function setPropietario(\JHWEB\VehiculoBundle\Entity\VhloPropietario $propietario = null)
    {
        $this->propietario = $propietario;

        return $this;
    }

    /**
     * Get propietario
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloPropietario
     */
    public function getPropietario()
    {
        return $this->propietario;
    }

    /**
     * Set tipoAlerta
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgTipoAlerta $tipoAlerta
     *
     * @return VhloAcreedor
     */
    public function setTipoAlerta(\JHWEB\VehiculoBundle\Entity\VhloCfgTipoAlerta $tipoAlerta = null)
    {
        $this->tipoAlerta = $tipoAlerta;

        return $this;
    }

    /**
     * Get tipoAlerta
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgTipoAlerta
     */
    public function getTipoAlerta()
    {
        return $this->tipoAlerta;
    }

    /**
     * Set vehiculo
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloVehiculo $vehiculo
     *
     * @return VhloAcreedor
     */
    public function setVehiculo(\JHWEB\VehiculoBundle\Entity\VhloVehiculo $vehiculo = null)
    {
        $this->vehiculo = $vehiculo;

        return $this;
    }

    /**
     * Get vehiculo
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloVehiculo
     */
    public function getVehiculo()
    {
        return $this->vehiculo;
    }
}
