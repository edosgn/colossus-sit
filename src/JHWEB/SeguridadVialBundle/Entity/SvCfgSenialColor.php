<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvCfgSenialColor
 *
 * @ORM\Table(name="sv_cfg_senial_color")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvCfgSenialColorRepository")
 */
class SvCfgSenialColor
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
     * @ORM\Column(name="hexadecimal", type="string", length=10)
     */
    private $hexadecimal;

    /**
     * @var bool
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
     * @return SvCfgSenialColor
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
     * Set hexadecimal
     *
     * @param string $hexadecimal
     *
     * @return SvCfgSenialColor
     */
    public function setHexadecimal($hexadecimal)
    {
        $this->hexadecimal = $hexadecimal;

        return $this;
    }

    /**
     * Get hexadecimal
     *
     * @return string
     */
    public function getHexadecimal()
    {
        return $this->hexadecimal;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return SvCfgSenialColor
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
