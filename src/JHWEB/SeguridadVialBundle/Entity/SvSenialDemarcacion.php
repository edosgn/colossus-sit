<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvSenialDemarcacion
 *
 * @ORM\Table(name="sv_senial_demarcacion")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvSenialDemarcacionRepository")
 */
class SvSenialDemarcacion
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
     * @var float
     *
     * @ORM\Column(name="cantidad", type="float")
     */
    private $cantidad;

    /**
     * @var float
     *
     * @ORM\Column(name="metraje", type="float")
     */
    private $metraje;

    /**
     * @var float
     *
     * @ORM\Column(name="ancho_linea", type="float", nullable=true)
     */
    private $anchoLinea;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float")
     */
    private $total;

    /**
     * @var string
     *
     * @ORM\Column(name="tramo_vial", type="text")
     */
    private $tramoVial;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /** @ORM\ManyToOne(targetEntity="SvCfgSenialLinea", inversedBy="demarcaciones") */
    private $linea;

    /** @ORM\ManyToOne(targetEntity="SvCfgSenialUnidadMedida", inversedBy="ubicaciones") */
    private $unidadMedida;

    /** @ORM\ManyToOne(targetEntity="SvSenialUbicacion", inversedBy="demarcaciones") */
    private $ubicacion;

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
     * Set cantidad
     *
     * @param float $cantidad
     *
     * @return SvSenialDemarcacion
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return float
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set metraje
     *
     * @param float $metraje
     *
     * @return SvSenialDemarcacion
     */
    public function setMetraje($metraje)
    {
        $this->metraje = $metraje;

        return $this;
    }

    /**
     * Get metraje
     *
     * @return float
     */
    public function getMetraje()
    {
        return $this->metraje;
    }

    /**
     * Set anchoLinea
     *
     * @param float $anchoLinea
     *
     * @return SvSenialDemarcacion
     */
    public function setAnchoLinea($anchoLinea)
    {
        $this->anchoLinea = $anchoLinea;

        return $this;
    }

    /**
     * Get anchoLinea
     *
     * @return float
     */
    public function getAnchoLinea()
    {
        return $this->anchoLinea;
    }

    /**
     * Set total
     *
     * @param float $total
     *
     * @return SvSenialDemarcacion
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set tramoVial
     *
     * @param string $tramoVial
     *
     * @return SvSenialDemarcacion
     */
    public function setTramoVial($tramoVial)
    {
        $this->tramoVial = $tramoVial;

        return $this;
    }

    /**
     * Get tramoVial
     *
     * @return string
     */
    public function getTramoVial()
    {
        return $this->tramoVial;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return SvSenialDemarcacion
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return bool
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set linea
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgSenialLinea $linea
     *
     * @return SvSenialDemarcacion
     */
    public function setLinea(\JHWEB\SeguridadVialBundle\Entity\SvCfgSenialLinea $linea = null)
    {
        $this->linea = $linea;

        return $this;
    }

    /**
     * Get linea
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgSenialLinea
     */
    public function getLinea()
    {
        return $this->linea;
    }

    /**
     * Set unidadMedida
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgSenialUnidadMedida $unidadMedida
     *
     * @return SvSenialDemarcacion
     */
    public function setUnidadMedida(\JHWEB\SeguridadVialBundle\Entity\SvCfgSenialUnidadMedida $unidadMedida = null)
    {
        $this->unidadMedida = $unidadMedida;

        return $this;
    }

    /**
     * Get unidadMedida
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgSenialUnidadMedida
     */
    public function getUnidadMedida()
    {
        return $this->unidadMedida;
    }

    /**
     * Set ubicacion
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvSenialUbicacion $ubicacion
     *
     * @return SvSenialDemarcacion
     */
    public function setUbicacion(\JHWEB\SeguridadVialBundle\Entity\SvSenialUbicacion $ubicacion = null)
    {
        $this->ubicacion = $ubicacion;

        return $this;
    }

    /**
     * Get ubicacion
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvSenialUbicacion
     */
    public function getUbicacion()
    {
        return $this->ubicacion;
    }
}
