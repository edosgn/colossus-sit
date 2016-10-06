<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Empresa
 *
 * @ORM\Table(name="empresa")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmpresaRepository")
 */
class Empresa
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
     * @ORM\Column(name="nit", type="integer")
     */
    private $nit;
 
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var int
     *
     * @ORM\Column(name="telefono", type="integer")
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=255)
     */
    private $correo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;
    

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Municipio", inversedBy="empresas") */
    private $municipio;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoEmpresa", inversedBy="empresas") */
    private $tipoEmpresa;

      /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ciudadano", inversedBy="empresas") */
    private $ciudadano;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\VehiculoPesado", mappedBy="empresa")
     */
    protected $vehiculosPesado;  

    public function __construct() {
        $this->vehiculosPesado = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nit
     *
     * @param integer $nit
     *
     * @return Empresa
     */
    public function setNit($nit)
    {
        $this->nit = $nit;

        return $this;
    }

    /**
     * Get nit
     *
     * @return integer
     */
    public function getNit()
    {
        return $this->nit;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Empresa
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
     * Set telefono
     *
     * @param integer $telefono
     *
     * @return Empresa
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return integer
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Empresa
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set correo
     *
     * @param string $correo
     *
     * @return Empresa
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get correo
     *
     * @return string
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set municipio
     *
     * @param \AppBundle\Entity\Municipio $municipio
     *
     * @return Empresa
     */
    public function setMunicipio(\AppBundle\Entity\Municipio $municipio = null)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return \AppBundle\Entity\Municipio
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * Set tipoEmpresa
     *
     * @param \AppBundle\Entity\TipoEmpresa $tipoEmpresa
     *
     * @return Empresa
     */
    public function setTipoEmpresa(\AppBundle\Entity\TipoEmpresa $tipoEmpresa = null)
    {
        $this->tipoEmpresa = $tipoEmpresa;

        return $this;
    }

    /**
     * Get tipoEmpresa
     *
     * @return \AppBundle\Entity\TipoEmpresa
     */
    public function getTipoEmpresa()
    {
        return $this->tipoEmpresa;
    }

    /**
     * Set ciudadano
     *
     * @param \AppBundle\Entity\Ciudadano $ciudadano
     *
     * @return Empresa
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
     * Add vehiculosPesado
     *
     * @param \AppBundle\Entity\VehiculoPesado $vehiculosPesado
     *
     * @return Empresa
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

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return Empresa
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
