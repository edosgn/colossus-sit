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

    /** @ORM\ManyToOne(targetEntity="JHWEB\ContravencionalBundle\Entity\CvCdoComparendo", inversedBy="facturas") */
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
     * @param \JHWEB\ContravencionalBundle\Entity\CvCdoComparendo $comparendo
     *
     * @return FroFacComparendo
     */
    public function setComparendo(\JHWEB\ContravencionalBundle\Entity\CvCdoComparendo $comparendo = null)
    {
        $this->comparendo = $comparendo;

        return $this;
    }

    /**
     * Get comparendo
     *
     * @return \JHWEB\ContravencionalBundle\Entity\CvCdoComparendo
     */
    public function getComparendo()
    {
        return $this->comparendo;
    }
}
