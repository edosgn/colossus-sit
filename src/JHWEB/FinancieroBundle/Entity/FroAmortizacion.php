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
     * @ORM\Column(name="numero_cuota", type="integer")
     */
    private $numeroCuota;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_limite", type="datetime")
     */
    private $fechaLimite;

    /**
     * @var float
     *
     * @ORM\Column(name="valor", type="float")
     */
    private $valor;

    /**
     * @ORM\OneToOne(targetEntity="FroFactura")
     */
    private $froFactura;

    /**
     * @ORM\OneToOne(targetEntity="FroAcuerdoPago")
     */
    private $froAcuerdoPago;


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
     * Set numeroCuota
     *
     * @param integer $numeroCuota
     *
     * @return FroAmortizacion
     */
    public function setNumeroCuota($numeroCuota)
    {
        $this->numeroCuota = $numeroCuota;

        return $this;
    }

    /**
     * Get numeroCuota
     *
     * @return integer
     */
    public function getNumeroCuota()
    {
        return $this->numeroCuota;
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
     * Set valor
     *
     * @param float $valor
     *
     * @return FroAmortizacion
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return float
     */
    public function getValor()
    {
        return $this->valor;
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
