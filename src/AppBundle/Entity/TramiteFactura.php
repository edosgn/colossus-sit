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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TramiteSistema", inversedBy="tramitesFacturas")
     **/
    protected $tramiteSistema;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Factura", inversedBy="tramitesFacturas")
     **/
    protected $factura;


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
     * Set tramiteSistema
     *
     * @param \AppBundle\Entity\TramiteSistema $tramiteSistema
     *
     * @return TramiteFactura
     */
    public function setTramiteSistema(\AppBundle\Entity\TramiteSistema $tramiteSistema = null)
    {
        $this->tramiteSistema = $tramiteSistema;

        return $this;
    }

    /**
     * Get tramiteSistema
     *
     * @return \AppBundle\Entity\TramiteSistema
     */
    public function getTramiteSistema()
    {
        return $this->tramiteSistema;
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
