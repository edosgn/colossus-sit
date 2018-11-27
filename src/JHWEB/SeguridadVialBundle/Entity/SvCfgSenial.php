<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvCfgSenial
 *
 * @ORM\Table(name="sv_cfg_senial")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvCfgSenialRepository")
 */
class SvCfgSenial
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
     * @ORM\Column(name="codigo", type="string", length=50, nullable=true)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var int
     *
     * @ORM\Column(name="cantidad", type="integer", nullable=true)
     */
    private $cantidad;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /** @ORM\ManyToOne(targetEntity="SvCfgSenialTipo", inversedBy="seniales") */
    private $tipoSenial;

    /** @ORM\ManyToOne(targetEntity="SvCfgSenialColor", inversedBy="seniales") */
    private $color;


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
     * Set codigo
     *
     * @param string $codigo
     *
     * @return SvCfgSenial
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return SvCfgSenial
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
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return SvCfgSenial
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set logo
     *
     * @param string $logo
     *
     * @return SvCfgSenial
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return SvCfgSenial
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

    /**
     * Set tipoSenial
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgSenialTipo $tipoSenial
     *
     * @return SvCfgSenial
     */
    public function setTipoSenial(\JHWEB\SeguridadVialBundle\Entity\SvCfgSenialTipo $tipoSenial = null)
    {
        $this->tipoSenial = $tipoSenial;

        return $this;
    }

    /**
     * Get tipoSenial
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgSenialTipo
     */
    public function getTipoSenial()
    {
        return $this->tipoSenial;
    }

    /**
     * Set color
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgSenialColor $color
     *
     * @return SvCfgSenial
     */
    public function setColor(\JHWEB\SeguridadVialBundle\Entity\SvCfgSenialColor $color = null)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgSenialColor
     */
    public function getColor()
    {
        return $this->color;
    }
}
