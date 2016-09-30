<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ciudadano
 *
 * @ORM\Table(name="ciudadano")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CiudadanoRepository")
 */
class Ciudadano
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
     * @ORM\Column(name="numeroIdentificacion", type="integer")
     */
    private $numeroIdentificacion;

    /**
     * @var string
     *
     * @ORM\Column(name="nombres", type="string", length=255)
     */
    private $nombres;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=255)
     */
    private $apellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=255)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=255)
     */
    private $correo;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoIdentificacion", inversedBy="ciudadanos") */
    private $tipoIdentificacion;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CiudadanoVehiculo", mappedBy="ciudadano")
     */
    protected $ciudadanosVehiculo; 

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Empresa", mappedBy="ciudadano")
     */
    protected $empresas;  

    public function __construct() {
        $this->ciudadanosVehiculo = new \Doctrine\Common\Collections\ArrayCollection();
        $this->empresas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->getNombres();
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
     * Set numeroIdentificacion
     *
     * @param integer $numeroIdentificacion
     *
     * @return Ciudadano
     */
    public function setNumeroIdentificacion($numeroIdentificacion)
    {
        $this->numeroIdentificacion = $numeroIdentificacion;

        return $this;
    }

    /**
     * Get numeroIdentificacion
     *
     * @return integer
     */
    public function getNumeroIdentificacion()
    {
        return $this->numeroIdentificacion;
    }

    /**
     * Set nombres
     *
     * @param string $nombres
     *
     * @return Ciudadano
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;

        return $this;
    }

    /**
     * Get nombres
     *
     * @return string
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     *
     * @return Ciudadano
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Ciudadano
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
     * Set telefono
     *
     * @param string $telefono
     *
     * @return Ciudadano
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set correo
     *
     * @param string $correo
     *
     * @return Ciudadano
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
     * Set tipoIdentificacion
     *
     * @param \AppBundle\Entity\TipoIdentificacion $tipoIdentificacion
     *
     * @return Ciudadano
     */
    public function setTipoIdentificacion(\AppBundle\Entity\TipoIdentificacion $tipoIdentificacion = null)
    {
        $this->tipoIdentificacion = $tipoIdentificacion;

        return $this;
    }

    /**
     * Get tipoIdentificacion
     *
     * @return \AppBundle\Entity\TipoIdentificacion
     */
    public function getTipoIdentificacion()
    {
        return $this->tipoIdentificacion;
    }

    /**
     * Add ciudadanosVehiculo
     *
     * @param \AppBundle\Entity\CiudadanoVehiculo $ciudadanosVehiculo
     *
     * @return Ciudadano
     */
    public function addCiudadanosVehiculo(\AppBundle\Entity\CiudadanoVehiculo $ciudadanosVehiculo)
    {
        $this->ciudadanosVehiculo[] = $ciudadanosVehiculo;

        return $this;
    }

    /**
     * Remove ciudadanosVehiculo
     *
     * @param \AppBundle\Entity\CiudadanoVehiculo $ciudadanosVehiculo
     */
    public function removeCiudadanosVehiculo(\AppBundle\Entity\CiudadanoVehiculo $ciudadanosVehiculo)
    {
        $this->ciudadanosVehiculo->removeElement($ciudadanosVehiculo);
    }

    /**
     * Get ciudadanosVehiculo
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCiudadanosVehiculo()
    {
        return $this->ciudadanosVehiculo;
    }

    /**
     * Add empresa
     *
     * @param \AppBundle\Entity\Empresa $empresa
     *
     * @return Ciudadano
     */
    public function addEmpresa(\AppBundle\Entity\Empresa $empresa)
    {
        $this->empresas[] = $empresa;

        return $this;
    }

    /**
     * Remove empresa
     *
     * @param \AppBundle\Entity\Empresa $empresa
     */
    public function removeEmpresa(\AppBundle\Entity\Empresa $empresa)
    {
        $this->empresas->removeElement($empresa);
    }

    /**
     * Get empresas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmpresas()
    {
        return $this->empresas;
    }
}
