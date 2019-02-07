<?php

namespace JHWEB\FinancieroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FroFacTramite
 *
 * @ORM\Table(name="fro_fac_tramite")
 * @ORM\Entity(repositoryClass="JHWEB\FinancieroBundle\Repository\FroFacTramiteRepository")
 */
class FroFacTramite
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
     * @var bool
     *
     * @ORM\Column(name="realizado", type="boolean")
     */
    private $realizado;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="FroFactura", inversedBy="tramites")
     */
    private $factura;

    /**
     * @ORM\ManyToOne(targetEntity="FroTrtePrecio", inversedBy="tramites")
     **/
    protected $precio;


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
     * Set realizado
     *
     * @param boolean $realizado
     *
     * @return FroFacTramite
     */
    public function setRealizado($realizado)
    {
        $this->realizado = $realizado;

        return $this;
    }

    /**
     * Get realizado
     *
     * @return bool
     */
    public function getRealizado()
    {
        return $this->realizado;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return FroFacTramite
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
     * Set factura
     *
     * @param \JHWEB\FinancieroBundle\Entity\FroFactura $factura
     *
     * @return FroFacTramite
     */
    public function setFactura(\JHWEB\FinancieroBundle\Entity\FroFactura $factura = null)
    {
        $this->factura = $factura;

        return $this;
    }

    /**
     * Get factura
     *
     * @return \JHWEB\FinancieroBundle\Entity\FroFactura
     */
    public function getFactura()
    {
        return $this->factura;
    }

    /**
     * Set precio
     *
     * @param \JHWEB\FinancieroBundle\Entity\FroTrtePrecio $precio
     *
     * @return FroFacTramite
     */
    public function setPrecio(\JHWEB\FinancieroBundle\Entity\FroTrtePrecio $precio = null)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return \JHWEB\FinancieroBundle\Entity\FroTrtePrecio
     */
    public function getPrecio()
    {
        return $this->precio;
    }
}