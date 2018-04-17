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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tramite", inversedBy="tramitesFacturas")
     **/
    protected $tramite;

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
     * Set tramite
     *
     * @param \AppBundle\Entity\Tramite $tramite
     *
     * @return TramiteFactura
     */
    public function setTramite(\AppBundle\Entity\Tramite $tramite = null)
    {
        $this->tramite = $tramite;

        return $this;
    }

    /**
     * Get tramite
     *
     * @return \AppBundle\Entity\Tramite
     */
    public function getTramite()
    {
        return $this->tramite;
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
