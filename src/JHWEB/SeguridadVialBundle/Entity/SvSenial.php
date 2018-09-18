<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvSenial
 *
 * @ORM\Table(name="sv_senial")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvSenialRepository")
 */
class SvSenial
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var int
     *
     * @ORM\Column(name="cantidad", type="integer")
     */
    private $cantidad;

    /**
     * @var float
     *
     * @ORM\Column(name="valor", type="float")
     */
    private $valor;

    /**
     * @var string
     *
     * @ORM\Column(name="adjunto", type="string", length=255)
     */
    private $adjunto;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=50)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=255, nullable=true)
     */
    private $logo;

    /** @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgSvUnidadMedida", inversedBy="seniales") */
    private $unidadMedida;

    /** @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgSvSenialEstado", inversedBy="seniales") */
    private $estado;

    /** @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgSvSenialColor", inversedBy="seniales") */
    private $color;

    /** @ORM\ManyToOne(targetEntity="SvSenialInventarioBodega", inversedBy="seniales") */
    private $inventario;

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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return SvSenial
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return SvSenial
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
     * Set valor
     *
     * @param float $valor
     *
     * @return SvSenial
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return float
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set adjunto
     *
     * @param string $adjunto
     *
     * @return SvSenial
     */
    public function setAdjunto($adjunto)
    {
        $this->adjunto = $adjunto;

        return $this;
    }

    /**
     * Get adjunto
     *
     * @return string
     */
    public function getAdjunto()
    {
        return $this->adjunto;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     *
     * @return SvSenial
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
     * @return SvSenial
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
     * Set logo
     *
     * @param string $logo
     *
     * @return SvSenial
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
     * Set unidadMedida
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgSvUnidadMedida $unidadMedida
     *
     * @return SvSenial
     */
    public function setUnidadMedida(\JHWEB\ConfigBundle\Entity\CfgSvUnidadMedida $unidadMedida = null)
    {
        $this->unidadMedida = $unidadMedida;

        return $this;
    }

    /**
     * Get unidadMedida
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgSvUnidadMedida
     */
    public function getUnidadMedida()
    {
        return $this->unidadMedida;
    }

    /**
     * Set estado
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgSvSenialEstado $estado
     *
     * @return SvSenial
     */
    public function setEstado(\JHWEB\ConfigBundle\Entity\CfgSvSenialEstado $estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgSvSenialEstado
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set color
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgSvSenialColor $color
     *
     * @return SvSenial
     */
    public function setColor(\JHWEB\ConfigBundle\Entity\CfgSvSenialColor $color = null)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgSvSenialColor
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set inventario
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvSenialInventarioBodega $inventario
     *
     * @return SvSenial
     */
    public function setInventario(\JHWEB\SeguridadVialBundle\Entity\SvSenialInventarioBodega $inventario = null)
    {
        $this->inventario = $inventario;

        return $this;
    }

    /**
     * Get inventario
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvSenialInventarioBodega
     */
    public function getInventario()
    {
        return $this->inventario;
    }
}
