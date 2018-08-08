<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TramiteFactura
 *
 * @ORM\Table(name="tramite_factura")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TramiteFacturaRepository")
 */
class TramiteFactura
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
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /**
     * @var boolean
     *
     * @ORM\Column(name="realizado", type="boolean")
     */
    private $realizado;

    /**
     * @var int
     *
     * @ORM\Column(name="cantidad", type="integer", nullable=true)
     */
    private $cantidad;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TramitePrecio", inversedBy="tramitesFacturas")
     **/
    protected $tramitePrecio;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Factura", inversedBy="tramitesFacturas")
     **/
    protected $factura;


   

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return TramiteFactura
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
     * Set realizado
     *
     * @param boolean $realizado
     *
     * @return TramiteFactura
     */
    public function setRealizado($realizado)
    {
        $this->realizado = $realizado;

        return $this;
    }

    /**
     * Get realizado
     *
     * @return boolean
     */
    public function getRealizado()
    {
        return $this->realizado;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return TramiteFactura
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
     * Set tramitePrecio
     *
     * @param \AppBundle\Entity\TramitePrecio $tramitePrecio
     *
     * @return TramiteFactura
     */
    public function setTramitePrecio(\AppBundle\Entity\TramitePrecio $tramitePrecio = null)
    {
        $this->tramitePrecio = $tramitePrecio;

        return $this;
    }

    /**
     * Get tramitePrecio
     *
     * @return \AppBundle\Entity\TramitePrecio
     */
    public function getTramitePrecio()
    {
        return $this->tramitePrecio;
    }

    /**
     * Set factura
     *
     * @param \AppBundle\Entity\Factura $factura
     *
     * @return TramiteFactura
     */
    public function setFactura(\AppBundle\Entity\Factura $factura = null)
    {
        $this->factura = $factura;

        return $this;
    }

    /**
     * Get factura
     *
     * @return \AppBundle\Entity\Factura
     */
    public function getFactura()
    {
        return $this->factura;
    }
}
