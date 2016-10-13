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
     * @ORM\Column(name="numero_identificacion", type="integer")
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

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoIdentificacion", inversedBy="ciudadanos") */
    private $tipoIdentificacion;

   

    public function __toString()
    {
        return $this->getNombres();
    } 


   

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
     * Set estado
     *
     * @param boolean $estado
     *
     * @return Ciudadano
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
}
