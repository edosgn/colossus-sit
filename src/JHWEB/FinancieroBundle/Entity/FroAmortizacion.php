<?php

namespace JHWEB\FinancieroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FroAmortizacion
 *
 * @ORM\Table(name="fro_amortizacion")
 * @ORM\Entity(repositoryClass="JHWEB\FinancieroBundle\Repository\FroAmortizacionRepository")
 */
class FroAmortizacion
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
     * @var int
     *
     * @ORM\Column(name="numCuota", type="integer")
     */
    private $numCuota;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaLimite", type="datetime")
     */
    private $fechaLimite;

    /**
     * @var float
     *
     * @ORM\Column(name="vamor", type="float")
     */
    private $vamor;

    /**
     * @ORM\OneToOne(targetEntity="FroFactura")
     */
    private $froFactura;



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
     * Set numCuota
     *
     * @param integer $numCuota
     *
     * @return FroAmortizacion
     */
    public function setNumCuota($numCuota)
    {
        $this->numCuota = $numCuota;

        return $this;
    }

    /**
     * Get numCuota
     *
     * @return integer
     */
    public function getNumCuota()
    {
        return $this->numCuota;
    }

    /**
     * Set fechaLimite
     *
     * @param \DateTime $fechaLimite
     *
     * @return FroAmortizacion
     */
    public function setFechaLimite($fechaLimite)
    {
        $this->fechaLimite = $fechaLimite;

        return $this;
    }

    /**
     * Get fechaLimite
     *
     * @return \DateTime
     */
    public function getFechaLimite()
    {
        return $this->fechaLimite;
    }

    /**
     * Set vamor
     *
     * @param float $vamor
     *
     * @return FroAmortizacion
     */
    public function setVamor($vamor)
    {
        $this->vamor = $vamor;

        return $this;
    }

    /**
     * Get vamor
     *
     * @return float
     */
    public function getVamor()
    {
        return $this->vamor;
    }

    /**
     * Set froFactura
     *
     * @param \JHWEB\FinancieroBundle\Entity\FroFactura $froFactura
     *
     * @return FroAmortizacion
     */
    public function setFroFactura(\JHWEB\FinancieroBundle\Entity\FroFactura $froFactura = null)
    {
        $this->froFactura = $froFactura;

        return $this;
    }

    /**
     * Get froFactura
     *
     * @return \JHWEB\FinancieroBundle\Entity\FroFactura
     */
    public function getFroFactura()
    {
        return $this->froFactura;
    }
}
