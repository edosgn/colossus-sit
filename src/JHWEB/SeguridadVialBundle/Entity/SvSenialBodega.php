<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvSenialBodega
 *
 * @ORM\Table(name="sv_senial_bodega")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvSenialBodegaRepository")
 */
class SvSenialBodega
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
     * @var \DateTime
     *
     * @ORM\Column(name="hora", type="time")
     */
    private $hora;

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
     * @ORM\Column(name="adjunto", type="string", length=255, nullable=true)
     */
    private $adjunto;

    /** @ORM\ManyToOne(targetEntity="SvCfgSenial", inversedBy="bodegas") */
    private $senial;

    /** @ORM\ManyToOne(targetEntity="SvCfgSenialEstado", inversedBy="bodegas") */
    private $estado;

    /** @ORM\ManyToOne(targetEntity="SvSenialInventario", inversedBy="bodegas") */
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
     * @return SvSenialBodega
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
        if ($this->fecha) {
            return $this->fecha->format('d/m/Y');
        }
        return $this->fecha;
    }

    /**
     * Set hora
     *
     * @param \DateTime $hora
     *
     * @return SvSenialBodega
     */
    public function setHora($hora)
    {
        $this->hora = $hora;

        return $this;
    }

    /**
     * Get hora
     *
     * @return \DateTime
     */
    public function getHora()
    {
        if ($this->hora) {
            return $this->hora->format('h:m:i A');
        }
        return $this->hora;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return SvSenialBodega
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
     * @return SvSenialBodega
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
     * @return SvSenialBodega
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
     * Set senial
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgSenial $senial
     *
     * @return SvSenialBodega
     */
    public function setSenial(\JHWEB\SeguridadVialBundle\Entity\SvCfgSenial $senial = null)
    {
        $this->senial = $senial;

        return $this;
    }

    /**
     * Get senial
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgSenial
     */
    public function getSenial()
    {
        return $this->senial;
    }

    /**
     * Set estado
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgSenialEstado $estado
     *
     * @return SvSenialBodega
     */
    public function setEstado(\JHWEB\SeguridadVialBundle\Entity\SvCfgSenialEstado $estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgSenialEstado
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set inventario
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvSenialInventario $inventario
     *
     * @return SvSenialBodega
     */
    public function setInventario(\JHWEB\SeguridadVialBundle\Entity\SvSenialInventario $inventario = null)
    {
        $this->inventario = $inventario;

        return $this;
    }

    /**
     * Get inventario
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvSenialInventario
     */
    public function getInventario()
    {
        return $this->inventario;
    }
}
