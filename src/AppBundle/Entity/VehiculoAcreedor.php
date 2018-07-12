<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VehiculoAcreedor
 *
 * @ORM\Table(name="vehiculo_acreedor")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VehiculoAcreedorRepository")
 */
class VehiculoAcreedor
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
     * @var bool
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado = true;
    
    /**
     * @var int
     *
     * @ORM\Column(name="grado_alerta", type="integer", nullable= true)
     */
    private $gradoAlerta;
    
    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ciudadano", inversedBy="propietariosVehiculo") */
    private $ciudadano; 
 
    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Empresa", inversedBy="propietariosVehiculo") */
    private $empresa;


    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehiculo", inversedBy="propietariosVehiculo") */
    private $vehiculo;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\CfgTipoAlerta", inversedBy="propietariosVehiculo") */
    private $cfgTipoAlerta;



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
     * Set estado
     *
     * @param boolean $estado
     *
     * @return VehiculoAcreedor
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
     * Set gradoAlerta
     *
     * @param integer $gradoAlerta
     *
     * @return VehiculoAcreedor
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
     * Set ciudadano
     *
     * @param \AppBundle\Entity\Ciudadano $ciudadano
     *
     * @return VehiculoAcreedor
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
     * Set empresa
     *
     * @param \AppBundle\Entity\Empresa $empresa
     *
     * @return VehiculoAcreedor
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

    /**
     * Set vehiculo
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculo
     *
     * @return VehiculoAcreedor
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
     * Set cfgTipoAlerta
     *
     * @param \AppBundle\Entity\CfgTipoAlerta $cfgTipoAlerta
     *
     * @return VehiculoAcreedor
     */
    public function setCfgTipoAlerta(\AppBundle\Entity\CfgTipoAlerta $cfgTipoAlerta = null)
    {
        $this->cfgTipoAlerta = $cfgTipoAlerta;

        return $this;
    }

    /**
     * Get cfgTipoAlerta
     *
     * @return \AppBundle\Entity\CfgTipoAlerta
     */
    public function getCfgTipoAlerta()
    {
        return $this->cfgTipoAlerta;
    }
}
