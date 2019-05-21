<?php

namespace JHWEB\ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CfgPropietario
 *
 * @ORM\Table(name="cfg_propietario")
 * @ORM\Entity(repositoryClass="JHWEB\ConfigBundle\Repository\CfgPropietarioRepository")
 */
class CfgPropietario
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
     * @var string
     *
     * @ORM\Column(name="nit", type="string", length=255, nullable=true)
     */
    private $nit;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255, nullable=true)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=255, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=255, nullable=true)
     */
    private $correo;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen_cabecera", type="string", length=255)
     */
    private $imagenCabecera;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen_pie", type="string", length=255)
     */
    private $imagenPie;


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
     * @return CfgPropietario
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
     * Set nit
     *
     * @param string $nit
     *
     * @return CfgPropietario
     */
    public function setNit($nit)
    {
        $this->nit = $nit;

        return $this;
    }

    /**
     * Get nit
     *
     * @return string
     */
    public function getNit()
    {
        return $this->nit;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return CfgPropietario
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
     * @return CfgPropietario
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
     * @return CfgPropietario
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
     * Set imagenCabecera
     *
     * @param string $imagenCabecera
     *
     * @return CfgPropietario
     */
    public function setImagenCabecera($imagenCabecera)
    {
        $this->imagenCabecera = $imagenCabecera;

        return $this;
    }

    /**
     * Get imagenCabecera
     *
     * @return string
     */
    public function getImagenCabecera()
    {
        return $this->imagenCabecera;
    }

    /**
     * Set imagenPie
     *
     * @param string $imagenPie
     *
     * @return CfgPropietario
     */
    public function setImagenPie($imagenPie)
    {
        $this->imagenPie = $imagenPie;

        return $this;
    }

    /**
     * Get imagenPie
     *
     * @return string
     */
    public function getImagenPie()
    {
        return $this->imagenPie;
    }
}

