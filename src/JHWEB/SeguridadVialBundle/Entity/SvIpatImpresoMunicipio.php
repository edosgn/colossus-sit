<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvIpatImpresoMunicipio
 *
 * @ORM\Table(name="sv_ipat_impreso_municipio")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvIpatImpresoMunicipioRepository")
 */
class SvIpatImpresoMunicipio
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
     * @var string
     *
     * @ORM\Column(name="numeroActa", type="string", length=255)
     */
    private $numeroActa;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvIpatImoresoBodega", inversedBy="SvIpatOrganismosransito")
     */
    private $impresoBodega;


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
     * @return SvIpatImpresoMunicipio
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
     * @return SvIpatImpresoMunicipio
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return int
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set numeroActa
     *
     * @param string $numeroActa
     *
     * @return SvIpatImpresoMunicipio
     */
    public function setNumeroActa($numeroActa)
    {
        $this->numeroActa = $numeroActa;

        return $this;
    }

    /**
     * Get numeroActa
     *
     * @return string
     */
    public function getNumeroActa()
    {
        return $this->numeroActa;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return SvIpatImpresoMunicipio
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
     * Set impresoBodega
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvIpatImoresoBodega $impresoBodega
     *
     * @return SvIpatImpresoMunicipio
     */
    public function setImpresoBodega(\JHWEB\SeguridadVialBundle\Entity\SvIpatImoresoBodega $impresoBodega = null)
    {
        $this->impresoBodega = $impresoBodega;

        return $this;
    }

    /**
     * Get impresoBodega
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvIpatImoresoBodega
     */
    public function getImpresoBodega()
    {
        return $this->impresoBodega;
    }
}
