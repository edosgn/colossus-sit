<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Linea
 *
 * @ORM\Table(name="linea")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LineaRepository")
 */
class Linea 
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
     * @ORM\Column(name="codigoMt", type="integer")
     */
    private $codigoMt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;
    

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Marca", inversedBy="lineas") */
    private $marca;

   


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
     * @return Linea
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
     * @return Linea
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
     * Set marca
     *
     * @param \AppBundle\Entity\Marca $marca
     *
     * @return Linea
     */
    public function setMarca(\AppBundle\Entity\Marca $marca = null)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get marca
     *
     * @return \AppBundle\Entity\Marca
     */
    public function getMarca()
    {
        return $this->marca;
    }

   

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return Linea
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
