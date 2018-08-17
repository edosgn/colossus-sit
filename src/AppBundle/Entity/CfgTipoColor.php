<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CfgTipoColor
 *
 * @ORM\Table(name="cfg_tipo_color")
 * @ORM\Entity
 */
class CfgTipoColor
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=false)
     */
    private $nombre;
	
	/**
     * @var string
     *
     * @ORM\Column(name="hex", type="string", length=10, nullable=false)
     */
    private $hex;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean", nullable=false)
     */
    private $estado;



    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CfgTipoColor
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
     * Set hex
     *
     * @param string $hex
     *
     * @return CfgTipoColor
     */
    public function setHex($hex)
    {
        $this->hex = $hex;

        return $this;
    }

    /**
     * Get hex
     *
     * @return string
     */
    public function getHex()
    {
        return $this->hex;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return CfgTipoColor
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
