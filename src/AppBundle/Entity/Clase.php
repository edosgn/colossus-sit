<?php

namespace AppBundle\Entity;
 
use Doctrine\ORM\Mapping as ORM;

/**
 * Clase
 *
 * @ORM\Table(name="clase")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClaseRepository")
 */
class Clase
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
     * @var int
     *
     * @ORM\Column(name="codigo_mt", type="integer", unique=true)
     */
    private $codigoMt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

   

     public function __toString()
    {
        return $this->getNombre();
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Clase
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
     * Set codigoMt
     *
     * @param integer $codigoMt
     *
     * @return Clase
     */
    public function setCodigoMt($codigoMt)
    {
        $this->codigoMt = $codigoMt;

        return $this;
    }

    /**
     * Get codigoMt
     *
     * @return integer
     */
    public function getCodigoMt()
    {
        return $this->codigoMt;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return Clase
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
