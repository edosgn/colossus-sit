<?php

namespace JHWEB\ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CfgModulo
 *
 * @ORM\Table(name="cfg_modulo")
 * @ORM\Entity(repositoryClass="JHWEB\ConfigBundle\Repository\CfgModuloRepository")
 */
class CfgModulo
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
     * @ORM\Column(name="abreviatura", type="string", length=10)
     */
    private $abreviatura;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="sigla_sustrato", type="string", length=10)
     */
    private $siglaSustrato;

    /**
     * @var boolean
     *
     * @ORM\Column(name="vehiculo", type="boolean")
     */
    private $vehiculo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;


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
     * @return CfgModulo
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
     * Set abreviatura
     *
     * @param string $abreviatura
     *
     * @return CfgModulo
     */
    public function setAbreviatura($abreviatura)
    {
        $this->abreviatura = $abreviatura;

        return $this;
    }

    /**
     * Get abreviatura
     *
     * @return string
     */
    public function getAbreviatura()
    {
        return $this->abreviatura;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return CfgModulo
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set siglaSustrato
     *
     * @param string $siglaSustrato
     *
     * @return CfgModulo
     */
    public function setSiglaSustrato($siglaSustrato)
    {
        $this->siglaSustrato = $siglaSustrato;

        return $this;
    }

    /**
     * Get siglaSustrato
     *
     * @return string
     */
    public function getSiglaSustrato()
    {
        return $this->siglaSustrato;
    }

    /**
     * Set vehiculo
     *
     * @param boolean $vehiculo
     *
     * @return CfgModulo
     */
    public function setVehiculo($vehiculo)
    {
        $this->vehiculo = $vehiculo;

        return $this;
    }

    /**
     * Get vehiculo
     *
     * @return boolean
     */
    public function getVehiculo()
    {
        return $this->vehiculo;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CfgModulo
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
}
