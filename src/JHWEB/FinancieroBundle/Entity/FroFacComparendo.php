<?php

namespace JHWEB\FinancieroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FroFacComparendo
 *
 * @ORM\Table(name="fro_fac_comparendo")
 * @ORM\Entity(repositoryClass="JHWEB\FinancieroBundle\Repository\FroFacComparendoRepository")
 */
class FroFacComparendo
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
     * @ORM\ManyToOne(targetEntity="FroFactura", inversedBy="comparendos")
     */
    private $factura;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Comparendo", inversedBy="facturas") */
    private $comparendo;


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
     * Set factura
     *
     * @param \JHWEB\FinancieroBundle\Entity\FroFactura $factura
     *
     * @return FroFacComparendo
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
     * Set comparendo
     *
     * @param \AppBundle\Entity\Comparendo $comparendo
     *
     * @return FroFacComparendo
     */
    public function setComparendo(\AppBundle\Entity\Comparendo $comparendo = null)
    {
        $this->comparendo = $comparendo;

        return $this;
    }

    /**
     * Get comparendo
     *
     * @return \AppBundle\Entity\Comparendo
     */
    public function getComparendo()
    {
        return $this->comparendo;
    }
}