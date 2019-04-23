<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvIpatImpresoBodega
 *
 * @ORM\Table(name="sv_ipat_impreso_bodega")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvIpatImpresoBodegaRepository")
 */
class SvIpatImpresoBodega
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
     * @ORM\Column(name="cantidad_disponible", type="integer")
     */
    private $cantidadDisponible;

    /**
     * @var int
     *
     * @ORM\Column(name="cantidad_recibida", type="integer")
     */
    private $cantidadRecibida;

    /**
     * @var bool
     *
     * @ORM\Column(name="estado", type="string")
     */
    private $estado;

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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return SvIpatImpresoBodega
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
     * Set cantidadDisponible
     *
     * @param integer $cantidadDisponible
     *
     * @return SvIpatImpresoBodega
     */
    public function setCantidadDisponible($cantidadDisponible)
    {
        $this->cantidadDisponible = $cantidadDisponible;

        return $this;
    }

    /**
     * Get cantidadDisponible
     *
     * @return integer
     */
    public function getCantidadDisponible()
    {
        return $this->cantidadDisponible;
    }

    /**
     * Set cantidadRecibida
     *
     * @param integer $cantidadRecibida
     *
     * @return SvIpatImpresoBodega
     */
    public function setCantidadRecibida($cantidadRecibida)
    {
        $this->cantidadRecibida = $cantidadRecibida;

        return $this;
    }

    /**
     * Get cantidadRecibida
     *
     * @return integer
     */
    public function getCantidadRecibida()
    {
        return $this->cantidadRecibida;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return SvIpatImpresoBodega
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
