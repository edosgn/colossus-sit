<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modulo
 *
 * @ORM\Table(name="modulo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModuloRepository")
 */
class Modulo
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
     * @ORM\Column(name="siglaSustrato", type="string", length=10)
     */
    private $siglaSustrato;

     /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="tramite", type="string", length=50)
     */
    private $tramite;

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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Modulo
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
     * @return Modulo
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
     * @return Modulo
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
     * @return Modulo
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
     * Set estado
     *
     * @param boolean $estado
     *
     * @return Modulo
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
     * Set tramite
     *
     * @param string $tramite
     *
     * @return Modulo
     */
    public function setTramite($tramite)
    {
        $this->tramite = $tramite;

        return $this;
    }

    /**
     * Get tramite
     *
     * @return string
     */
    public function getTramite()
    {
        return $this->tramite;
    }
}
